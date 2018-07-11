<?php

namespace App\Http\Controllers;

use App\DataTables\CashPaymentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCashPaymentRequest;
use App\Http\Requests\UpdateCashPaymentRequest;
use App\Models\Bank;
use App\Models\CustomerAccount;
use App\Models\Lease;
use App\Models\Payment;
use App\Repositories\CashPaymentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

class CashPaymentController extends AppBaseController
{
    /** @var  CashPaymentRepository */
    private $cashPaymentRepository;

    public function __construct(CashPaymentRepository $cashPaymentRepo)
    {
        $this->middleware('auth');
        $this->cashPaymentRepository = $cashPaymentRepo;
    }

    /**
     * Display a listing of the CashPayment.
     *
     * @param CashPaymentDataTable $cashPaymentDataTable
     * @return Response
     */
    public function index(CashPaymentDataTable $cashPaymentDataTable)
    {
        return $cashPaymentDataTable->render('cash_payments.index',[
            'tenants'=>Lease::where('status',true)->with(['masterfile','unit'])->get(),
            'banks'=>Bank::all()
        ]);
    }

    /**
     * Show the form for creating a new CashPayment.
     *
     * @return Response
     */
    public function create()
    {
        return view('cash_payments.create');
    }

    /**
     * Store a newly created CashPayment in storage.
     *
     * @param CreateCashPaymentRequest $request
     *
     * @return Response
     */
    public function store(CreateCashPaymentRequest $request)
    {
        $input = $request->all();
        $this->validate($request,[
            'ref_number'=>'required|unique:payments,ref_number'
        ]);

        DB::transaction(function()use ($input){
            $lease = Lease::where('id',$input['lease_id'])->with(['unit','masterfile'])->first();
            $payment = Payment::create([
                'payment_mode'=>$input['payment_mode'],
                'account_number'=>$lease->unit->unit_number,
                'ref_number'=>$input['ref_number'],
                'amount'=>$input['amount'],
//                'paybill'=>$request->BusinessShortCode,
                'phone_number'=>$lease->masterfile->phone_number,
                'BillRefNumber'=>$lease->unit->unit_number,
                'TransID'=>$input['ref_number'],
                'TransTime'=>$input['received_on'],
                'FirstName'=>$lease->masterfile->full_name,
//                'MiddleName'=>$request->MiddleName,
//                'LastName'=>$request->LastName,
//                'client_id' => $input['client_id'],
                'received_on'=>$input['received_on'],
                'mf_id'=>$lease->masterfile->id,
                'status'=>true,
                'house_number'=>$lease->unit_id,
                'tenant_id' => $lease->tenant_id,
                'created_by'=>Auth::user()->mf_id,
                'bank_id'=>$input['bank_id']
            ]);

            $acc = CustomerAccount::create([
                'tenant_id'=>$lease->tenant_id,
                'lease_id'=>$lease->id,
                'unit_id'=>$lease->unit->id,
                'payment_id'=>$payment->id,
                'ref_number'=>$payment->ref_number,
                'transaction_type'=>debit,
                'amount'=>$payment->amount,
                'date'=>$input['received_on']
            ]);


        });


        Flash::success('Cash Payment saved successfully.');

        return redirect(route('cashPayments.index'));
    }

    /**
     * Display the specified CashPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cashPayment = $this->cashPaymentRepository->findWithoutFail($id);

        if (empty($cashPayment)) {
            Flash::error('Cash Payment not found');

            return redirect(route('cashPayments.index'));
        }

        return response()->json($cashPayment);
    }

    /**
     * Show the form for editing the specified CashPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cashPayment = $this->cashPaymentRepository->findWithoutFail($id);

        if (empty($cashPayment)) {
            Flash::error('Cash Payment not found');

            return redirect(route('cashPayments.index'));
        }

        return view('cash_payments.edit')->with('cashPayment', $cashPayment);
    }

    /**
     * Update the specified CashPayment in storage.
     *
     * @param  int              $id
     * @param UpdateCashPaymentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCashPaymentRequest $request)
    {
        $cashPayment = $this->cashPaymentRepository->findWithoutFail($id);

        if (empty($cashPayment)) {
            Flash::error('Cash Payment not found');

            return redirect(route('cashPayments.index'));
        }
        DB::transaction(function()use ($request,$id){
            $cashPayment = $this->cashPaymentRepository->update($request->all(), $id);

            $customerAcc = CustomerAccount::where('payment_id',$cashPayment->id)->first();
            if(!is_null($customerAcc)){
                $customerAcc->date = $request->received_on;
                $customerAcc->save();
            }
        });


        Flash::success('Cash Payment updated successfully.');

        return redirect(route('cashPayments.index'));
    }

    /**
     * Remove the specified CashPayment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cashPayment = $this->cashPaymentRepository->findWithoutFail($id);

        if (empty($cashPayment)) {
            Flash::error('Cash Payment not found');

            return redirect(route('cashPayments.index'));
        }

        $this->cashPaymentRepository->delete($id);

        Flash::success('Cash Payment deleted successfully.');

        return redirect(route('cashPayments.index'));
    }
}
