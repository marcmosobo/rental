<?php

namespace App\Http\Controllers;

use App\DataTables\UnitServiceBillDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUnitServiceBillRequest;
use App\Http\Requests\UpdateUnitServiceBillRequest;
use App\Models\PropertyUnit;
use App\Models\ServiceOption;
use App\Models\UnitServiceBill;
use App\Repositories\UnitServiceBillRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Response;

class UnitServiceBillController extends AppBaseController
{
    /** @var  UnitServiceBillRepository */
    private $unitServiceBillRepository;

    public function __construct(UnitServiceBillRepository $unitServiceBillRepo)
    {
        $this->middleware('auth');
        $this->unitServiceBillRepository = $unitServiceBillRepo;
    }

    /**
     * Display a listing of the UnitServiceBill.
     *
     * @param UnitServiceBillDataTable $unitServiceBillDataTable
     * @return Response
     */
    public function index(UnitServiceBillDataTable $unitServiceBillDataTable)
    {
        return $unitServiceBillDataTable->render('unit_service_bills.index');
    }

    public function unitServiceBills($id)
    {
        $unit = PropertyUnit::find($id);
        if (empty($unit)) {
            Flash::error('Property unit does not exist');

            return redirect('properties');
        }
        $unitServiceBillDataTable = new UnitServiceBillDataTable($id);
        return $unitServiceBillDataTable->render('unit_service_bills.index',[
            'unit'=>$unit,
            'bills'=>ServiceOption::where('status',true)->get()
        ]);
    }

    /**
     * Show the form for creating a new UnitServiceBill.
     *
     * @return Response
     */
    public function create()
    {
        return view('unit_service_bills.create');
    }

    /**
     * Store a newly created UnitServiceBill in storage.
     *
     * @param CreateUnitServiceBillRequest $request
     *
     * @return Response
     */
    public function store(CreateUnitServiceBillRequest $request)
    {
        $this->validate($request,[
            'service_bill_id'=>Rule::unique('unit_service_bills')->where(function($query)use($request){
                return $query->where('unit_id',$request->unit_id);
            })
        ]);
        $input = $request->all();

        $unitServiceBill = $this->unitServiceBillRepository->create($input);

        Flash::success('Unit Service Bill saved successfully.');

        return redirect('unitBills/'.$request->unit_id);
    }

    /**
     * Display the specified UnitServiceBill.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $unitServiceBill = $this->unitServiceBillRepository->findWithoutFail($id);

        if (empty($unitServiceBill)) {
            Flash::error('Unit Service Bill not found');

            return redirect(route('unitServiceBills.index'));
        }

        return response()->json($unitServiceBill);
    }

    /**
     * Show the form for editing the specified UnitServiceBill.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $unitServiceBill = $this->unitServiceBillRepository->findWithoutFail($id);

        if (empty($unitServiceBill)) {
            Flash::error('Unit Service Bill not found');

            return redirect(route('unitServiceBills.index'));
        }

        return view('unit_service_bills.edit')->with('unitServiceBill', $unitServiceBill);
    }

    /**
     * Update the specified UnitServiceBill in storage.
     *
     * @param  int              $id
     * @param UpdateUnitServiceBillRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUnitServiceBillRequest $request)
    {
        $unitServiceBill = $this->unitServiceBillRepository->findWithoutFail($id);

        if (empty($unitServiceBill)) {
            Flash::error('Unit Service Bill not found');

            return redirect('unitBills/'.$request->unit_id);
        }

        $unitServiceBill = $this->unitServiceBillRepository->update($request->all(), $id);

        Flash::success('Unit Service Bill updated successfully.');

        return redirect('unitBills/'.$request->unit_id);
    }

    /**
     * Remove the specified UnitServiceBill from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $request,$id)
    {
        $unitServiceBill = $this->unitServiceBillRepository->findWithoutFail($id);

        if (empty($unitServiceBill)) {
            Flash::error('Unit Service Bill not found');
            return redirect('unitBills/'.$request->unit_id);
        }

        $this->unitServiceBillRepository->delete($id);

        Flash::success('Unit Service Bill deleted successfully.');

        return redirect('unitBills/'.$request->unit_id);
    }
}
