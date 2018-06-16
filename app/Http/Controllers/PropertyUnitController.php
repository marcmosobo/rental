<?php

namespace App\Http\Controllers;

use App\DataTables\PropertyUnitDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePropertyUnitRequest;
use App\Http\Requests\UpdatePropertyUnitRequest;
use App\Models\Property;
use App\Models\ServiceOption;
use App\Models\UnitServiceBill;
use App\Repositories\PropertyUnitRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class PropertyUnitController extends AppBaseController
{
    /** @var  PropertyUnitRepository */
    private $propertyUnitRepository;

    public function __construct(PropertyUnitRepository $propertyUnitRepo)
    {
        $this->middleware('auth');
        $this->propertyUnitRepository = $propertyUnitRepo;
    }

    /**
     * Display a listing of the PropertyUnit.
     *
     * @param PropertyUnitDataTable $propertyUnitDataTable
     * @return Response
     */
    public function index(PropertyUnitDataTable $propertyUnitDataTable)
    {
        return $propertyUnitDataTable->render('property_units.index');
    }


    public function propertyUnits($id)
    {
        $propertyUnit = Property::find($id);
        $propertyUnitDataTable = new PropertyUnitDataTable($id);

        if (empty($propertyUnit)) {
            Flash::error('You must select property to view units for');

            return redirect(route('properties.index'));
        }
        return $propertyUnitDataTable->render('property_units.index',[
            'property' => Property::find($id),
            'services'=> ServiceOption::where('status',true)->get()
        ]);
    }
    /**
     * Show the form for creating a new PropertyUnit.
     *
     * @return Response
     */
    public function create()
    {
        return view('property_units.create');
    }

    /**
     * Store a newly created PropertyUnit in storage.
     *
     * @param CreatePropertyUnitRequest $request
     *
     * @return Response
     */
    public function store(CreatePropertyUnitRequest $request)
    {


        $this->validate($request,[
            'property_id'=>'required',
            'service_bills'=>'required'
        ]);
        $propery = Property::find($request->property_id);
//        $request->unit_number = $propery->code.'-'.$request->unit_number;
        $input = $request->all();
//        print_r($input);die;
//        var_dump($request->unit_number);die;
        $this->validate($request,[
            'unit_number'=>'unique:property_units,unit_number'
        ]);

        $input['unit_number'] = $propery->code.'-'.$request->unit_number;

        DB::transaction(function()use($input){
            if(count($input['service_bills'])){
                $propertyUnit = $this->propertyUnitRepository->create($input);

                foreach ($input['service_bills'] as $bill){
                    if(isset($bill['service_bill_id']) && !empty($bill['service_bill_id'])){
                        if(!empty($bill['amount'])){
                            $service_bill = UnitServiceBill::create([
                              'unit_id'=>$propertyUnit->id,
                                'service_bill_id'=> $bill['service_bill_id'],
                                'amount'=>$bill['amount'],
                                'period'=>$bill['period']
                            ]);
                        }
                    }
                }
            }


        });


        Flash::success('Property Unit saved successfully.');

        return redirect('units/'.$request->property_id);
    }

    /**
     * Display the specified PropertyUnit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $propertyUnit = $this->propertyUnitRepository->findWithoutFail($id);

        if (empty($propertyUnit)) {
            Flash::error('Property Unit not found');

            return redirect(route('propertyUnits.index'));
        }

        return response()->json($propertyUnit);
    }

    /**
     * Show the form for editing the specified PropertyUnit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $propertyUnit = $this->propertyUnitRepository->findWithoutFail($id);

        if (empty($propertyUnit)) {
            Flash::error('Property Unit not found');

            return redirect(route('propertyUnits.index'));
        }

        return view('property_units.edit')->with('propertyUnit', $propertyUnit);
    }

    /**
     * Update the specified PropertyUnit in storage.
     *
     * @param  int              $id
     * @param UpdatePropertyUnitRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePropertyUnitRequest $request)
    {
        $propertyUnit = $this->propertyUnitRepository->findWithoutFail($id);

        if (empty($propertyUnit)) {
            Flash::error('Property Unit not found');

            return redirect('units/'.$request->property_id);
        }

        $propertyUnit = $this->propertyUnitRepository->update($request->all(), $id);

        Flash::success('Property Unit updated successfully.');

        return redirect('units/'.$request->property_id);
    }

    /**
     * Remove the specified PropertyUnit from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $request,$id)
    {
        $propertyUnit = $this->propertyUnitRepository->findWithoutFail($id);

        if (empty($propertyUnit)) {
            Flash::error('Property Unit not found');

            return redirect('units/'.$request->property_id);
        }

        $this->propertyUnitRepository->delete($id);

        Flash::success('Property Unit deleted successfully.');

        return redirect('units/'.$request->property_id);
    }
}
