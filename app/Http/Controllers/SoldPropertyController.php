<?php

namespace App\Http\Controllers;

use App\DataTables\SoldPropertyDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSoldPropertyRequest;
use App\Http\Requests\UpdateSoldPropertyRequest;
use App\Models\Masterfile;
use App\Models\PropertyListing;
use App\Repositories\SoldPropertyRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class SoldPropertyController extends AppBaseController
{
    /** @var  SoldPropertyRepository */
    private $soldPropertyRepository;

    public function __construct(SoldPropertyRepository $soldPropertyRepo)
    {
        $this->middleware('auth');
        $this->soldPropertyRepository = $soldPropertyRepo;
    }

    /**
     * Display a listing of the SoldProperty.
     *
     * @param SoldPropertyDataTable $soldPropertyDataTable
     * @return Response
     */
    public function index(SoldPropertyDataTable $soldPropertyDataTable)
    {
        return $soldPropertyDataTable->render('sold_properties.index',[
            'listings'=>PropertyListing::where('status',false)->with(['type','masterfile'])->get(),
            'buyers'=>Masterfile::where('b_role',customer)->get()
        ]);
    }

    /**
     * Show the form for creating a new SoldProperty.
     *
     * @return Response
     */
    public function create()
    {
        return view('sold_properties.create');
    }

    /**
     * Store a newly created SoldProperty in storage.
     *
     * @param CreateSoldPropertyRequest $request
     *
     * @return Response
     */
    public function store(CreateSoldPropertyRequest $request)
    {
        $input = $request->all();

        $listing = PropertyListing::find($request->listing_id);
        $input['commission_percentage'] = $listing->sale_commission;
        $input['commission_charged'] = $request->amount_bought * $listing->sale_commission/100;
        $input['less_commission'] = $request->amount_bought * (1 -($listing->sale_commission/100));

        $soldProperty = $this->soldPropertyRepository->create($input);
        $listing->status = true;
        $listing->save();

        Flash::success('Sold Property saved successfully.');

        return redirect(route('soldProperties.index'));
    }

    /**
     * Display the specified SoldProperty.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $soldProperty = $this->soldPropertyRepository->findWithoutFail($id);

        if (empty($soldProperty)) {
            Flash::error('Sold Property not found');

            return redirect(route('soldProperties.index'));
        }

        return view('sold_properties.show')->with('soldProperty', $soldProperty);
    }

    /**
     * Show the form for editing the specified SoldProperty.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $soldProperty = $this->soldPropertyRepository->findWithoutFail($id);

        if (empty($soldProperty)) {
            Flash::error('Sold Property not found');

            return redirect(route('soldProperties.index'));
        }

        return view('sold_properties.edit')->with('soldProperty', $soldProperty);
    }

    /**
     * Update the specified SoldProperty in storage.
     *
     * @param  int              $id
     * @param UpdateSoldPropertyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSoldPropertyRequest $request)
    {
        $soldProperty = $this->soldPropertyRepository->findWithoutFail($id);

        if (empty($soldProperty)) {
            Flash::error('Sold Property not found');

            return redirect(route('soldProperties.index'));
        }

        $soldProperty = $this->soldPropertyRepository->update($request->all(), $id);

        Flash::success('Sold Property updated successfully.');

        return redirect(route('soldProperties.index'));
    }

    /**
     * Remove the specified SoldProperty from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $soldProperty = $this->soldPropertyRepository->findWithoutFail($id);

        if (empty($soldProperty)) {
            Flash::error('Sold Property not found');

            return redirect(route('soldProperties.index'));
        }

        $this->soldPropertyRepository->delete($id);

        Flash::success('Sold Property deleted successfully.');

        return redirect(route('soldProperties.index'));
    }
}
