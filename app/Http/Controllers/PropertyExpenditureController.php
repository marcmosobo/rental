<?php

namespace App\Http\Controllers;

use App\DataTables\PropertyExpenditureDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePropertyExpenditureRequest;
use App\Http\Requests\UpdatePropertyExpenditureRequest;
use App\Models\Expenditure;
use App\Models\Masterfile;
use App\Models\Property;
use App\Repositories\PropertyExpenditureRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class PropertyExpenditureController extends AppBaseController
{
    /** @var  PropertyExpenditureRepository */
    private $propertyExpenditureRepository;

    public function __construct(PropertyExpenditureRepository $propertyExpenditureRepo)
    {
        $this->middleware('auth');
        $this->propertyExpenditureRepository = $propertyExpenditureRepo;
    }

    /**
     * Display a listing of the PropertyExpenditure.
     *
     * @param PropertyExpenditureDataTable $propertyExpenditureDataTable
     * @return Response
     */
    public function index(PropertyExpenditureDataTable $propertyExpenditureDataTable)
    {
        return $propertyExpenditureDataTable->render('property_expenditures.index',[
            'properties'=> Property::all(),
            'expenses'=>Expenditure::all()
        ]);
    }

    /**
     * Show the form for creating a new PropertyExpenditure.
     *
     * @return Response
     */
    public function create()
    {
        return view('property_expenditures.create');
    }

    /**
     * Store a newly created PropertyExpenditure in storage.
     *
     * @param CreatePropertyExpenditureRequest $request
     *
     * @return Response
     */
    public function store(CreatePropertyExpenditureRequest $request)
    {
        $input = $request->all();
        $this->validate($request,[
           'property_id'=>'required'
        ]);

        $property = Property::find($request->property_id);
        $input['landlord_id'] = $property->landlord_id;
        $input['created_by'] = Auth::user()->mf_id;
        $propertyExpenditure = $this->propertyExpenditureRepository->create($input);

        Flash::success('Property Expenditure saved successfully.');

        return redirect(route('propertyExpenditures.index'));
    }

    /**
     * Display the specified PropertyExpenditure.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $propertyExpenditure = $this->propertyExpenditureRepository->findWithoutFail($id);

        if (empty($propertyExpenditure)) {
            Flash::error('Property Expenditure not found');

            return redirect(route('propertyExpenditures.index'));
        }

        return response()->json($propertyExpenditure);
    }

    /**
     * Show the form for editing the specified PropertyExpenditure.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $propertyExpenditure = $this->propertyExpenditureRepository->findWithoutFail($id);

        if (empty($propertyExpenditure)) {
            Flash::error('Property Expenditure not found');

            return redirect(route('propertyExpenditures.index'));
        }

        return view('property_expenditures.edit')->with('propertyExpenditure', $propertyExpenditure);
    }

    /**
     * Update the specified PropertyExpenditure in storage.
     *
     * @param  int              $id
     * @param UpdatePropertyExpenditureRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePropertyExpenditureRequest $request)
    {
        $propertyExpenditure = $this->propertyExpenditureRepository->findWithoutFail($id);

        if (empty($propertyExpenditure)) {
            Flash::error('Property Expenditure not found');

            return redirect(route('propertyExpenditures.index'));
        }

        $propertyExpenditure = $this->propertyExpenditureRepository->update($request->all(), $id);

        Flash::success('Property Expenditure updated successfully.');

        return redirect(route('propertyExpenditures.index'));
    }

    /**
     * Remove the specified PropertyExpenditure from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $propertyExpenditure = $this->propertyExpenditureRepository->findWithoutFail($id);

        if (empty($propertyExpenditure)) {
            Flash::error('Property Expenditure not found');

            return redirect(route('propertyExpenditures.index'));
        }

        $this->propertyExpenditureRepository->delete($id);

        Flash::success('Property Expenditure deleted successfully.');

        return redirect(route('propertyExpenditures.index'));
    }
}
