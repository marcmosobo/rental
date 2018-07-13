<?php

namespace App\Http\Controllers;

use App\DataTables\PropertyListingDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePropertyListingRequest;
use App\Http\Requests\UpdatePropertyListingRequest;
use App\Models\Masterfile;
use App\Models\PropertyType;
use App\Repositories\PropertyListingRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PropertyListingController extends AppBaseController
{
    /** @var  PropertyListingRepository */
    private $propertyListingRepository;

    public function __construct(PropertyListingRepository $propertyListingRepo)
    {
        $this->propertyListingRepository = $propertyListingRepo;
    }

    /**
     * Display a listing of the PropertyListing.
     *
     * @param PropertyListingDataTable $propertyListingDataTable
     * @return Response
     */
    public function index(PropertyListingDataTable $propertyListingDataTable)
    {
        return $propertyListingDataTable->render('property_listings.index',[
            'sellers'=>Masterfile::where('b_role',customer)->get(),
            'types'=>PropertyType::all()
        ]);
    }

    /**
     * Show the form for creating a new PropertyListing.
     *
     * @return Response
     */
    public function create()
    {
        return view('property_listings.create');
    }

    /**
     * Store a newly created PropertyListing in storage.
     *
     * @param CreatePropertyListingRequest $request
     *
     * @return Response
     */
    public function store(CreatePropertyListingRequest $request)
    {
        $input = $request->all();

        $propertyListing = $this->propertyListingRepository->create($input);

        Flash::success('Property Listing saved successfully.');

        return redirect(route('propertyListings.index'));
    }

    /**
     * Display the specified PropertyListing.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $propertyListing = $this->propertyListingRepository->findWithoutFail($id);

        if (empty($propertyListing)) {
            Flash::error('Property Listing not found');

            return redirect(route('propertyListings.index'));
        }

        return view('property_listings.show')->with('propertyListing', $propertyListing);
    }

    /**
     * Show the form for editing the specified PropertyListing.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $propertyListing = $this->propertyListingRepository->findWithoutFail($id);

        if (empty($propertyListing)) {
            Flash::error('Property Listing not found');

            return redirect(route('propertyListings.index'));
        }

        return view('property_listings.edit')->with('propertyListing', $propertyListing);
    }

    /**
     * Update the specified PropertyListing in storage.
     *
     * @param  int              $id
     * @param UpdatePropertyListingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePropertyListingRequest $request)
    {
        $propertyListing = $this->propertyListingRepository->findWithoutFail($id);

        if (empty($propertyListing)) {
            Flash::error('Property Listing not found');

            return redirect(route('propertyListings.index'));
        }

        $propertyListing = $this->propertyListingRepository->update($request->all(), $id);

        Flash::success('Property Listing updated successfully.');

        return redirect(route('propertyListings.index'));
    }

    /**
     * Remove the specified PropertyListing from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $propertyListing = $this->propertyListingRepository->findWithoutFail($id);

        if (empty($propertyListing)) {
            Flash::error('Property Listing not found');

            return redirect(route('propertyListings.index'));
        }

        $this->propertyListingRepository->delete($id);

        Flash::success('Property Listing deleted successfully.');

        return redirect(route('propertyListings.index'));
    }
}
