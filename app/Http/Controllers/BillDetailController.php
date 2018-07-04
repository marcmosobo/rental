<?php

namespace App\Http\Controllers;

use App\DataTables\BillDetailDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateBillDetailRequest;
use App\Http\Requests\UpdateBillDetailRequest;
use App\Models\Bill;
use App\Models\CustomerAccount;
use App\Models\Lease;
use App\Models\ServiceOption;
use App\Repositories\BillDetailRepository;
use Carbon\Carbon;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

class BillDetailController extends AppBaseController
{
    /** @var  BillDetailRepository */
    private $billDetailRepository;

    public function __construct(BillDetailRepository $billDetailRepo)
    {
        $this->middleware('auth');
        $this->billDetailRepository = $billDetailRepo;
    }

    /**
     * Display a listing of the BillDetail.
     *
     * @param BillDetailDataTable $billDetailDataTable
     * @return Response
     */
    public function index(BillDetailDataTable $billDetailDataTable)
    {
        return $billDetailDataTable->render('bill_details.index',[
            'leases'=> Lease::where('status',true)->with(['unit','masterfile'])->get(),
            'bills'=> ServiceOption::all()
        ]);
    }

    /**
     * Show the form for creating a new BillDetail.
     *
     * @return Response
     */
    public function create()
    {
        return view('bill_details.create');
    }

    /**
     * Store a newly created BillDetail in storage.
     *
     * @param CreateBillDetailRequest $request
     *
     * @return Response
     */
    public function store(CreateBillDetailRequest $request)
    {
        $input = $request->all();

        DB::transaction(function()use($input){
            $lease = Lease::find($input['lease_id']);
            $bill = Bill::create([
                'lease_id'=>$input['lease_id'],
                'tenant_id'=>$lease->tenant_id,
                'property_id'=> $lease->property_id,
                'description'=>'Additional bill',
                'total'=> $input['amount'],
            ]);
            $input['bill_id'] = $bill->id;
            $input['balance'] = $input['amount'];
            $input['bill_date']= $input['date'];
            $input['created_by'] = Auth::user()->mf_id;
            $billDetail = $this->billDetailRepository->create($input);

            CustomerAccount::create([
                'lease_id'=>$input['lease_id'],
                'tenant_id'=>$lease->tenant_id,
                'bill_id'=> $bill->id,
                'unit_id'=> $lease->unit_id,
                'transaction_type'=>credit,
                'balance'=> $input['amount'],
                'amount'=>$input['amount'],
                'date'=>$input['date']
            ]);

        });



        Flash::success('Bill Details saved successfully.');

        return redirect(route('billDetails.index'));
    }

    /**
     * Display the specified BillDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $billDetail = $this->billDetailRepository->findWithoutFail($id);

        if (empty($billDetail)) {
            Flash::error('Bill Detail not found');

            return redirect(route('billDetails.index'));
        }

        return view('bill_details.show')->with('billDetail', $billDetail);
    }

    /**
     * Show the form for editing the specified BillDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $billDetail = $this->billDetailRepository->findWithoutFail($id);

        if (empty($billDetail)) {
            Flash::error('Bill Detail not found');

            return redirect(route('billDetails.index'));
        }

        return view('bill_details.edit')->with('billDetail', $billDetail);
    }

    /**
     * Update the specified BillDetail in storage.
     *
     * @param  int              $id
     * @param UpdateBillDetailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBillDetailRequest $request)
    {
        $billDetail = $this->billDetailRepository->findWithoutFail($id);

        if (empty($billDetail)) {
            Flash::error('Bill Detail not found');

            return redirect(route('billDetails.index'));
        }

        $billDetail = $this->billDetailRepository->update($request->all(), $id);

        Flash::success('Bill Detail updated successfully.');

        return redirect(route('billDetails.index'));
    }

    /**
     * Remove the specified BillDetail from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $billDetail = $this->billDetailRepository->findWithoutFail($id);

        if (empty($billDetail)) {
            Flash::error('Bill Detail not found');

            return redirect(route('billDetails.index'));
        }

        $this->billDetailRepository->delete($id);

        Flash::success('Bill Detail deleted successfully.');

        return redirect(route('billDetails.index'));
    }
}
