<?php

namespace App\Http\Controllers;

use App\DataTables\PaymentTransferDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePaymentTransferRequest;
use App\Http\Requests\UpdatePaymentTransferRequest;
use App\Models\CustomerAccount;
use App\Models\Lease;
use App\Models\Payment;
use App\Repositories\PaymentTransferRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

class PaymentTransferController extends AppBaseController
{
    /** @var  PaymentTransferRepository */
    private $paymentTransferRepository;

    public function __construct(PaymentTransferRepository $paymentTransferRepo)
    {
        $this->middleware('auth');
        $this->paymentTransferRepository = $paymentTransferRepo;
    }

    /**
     * Display a listing of the PaymentTransfer.
     *
     * @param PaymentTransferDataTable $paymentTransferDataTable
     * @return Response
     */
    public function index(PaymentTransferDataTable $paymentTransferDataTable)
    {
        return $paymentTransferDataTable->render('payment_transfers.index',[
            'payments'=>Payment::where('status',true)->with(['masterfile','unit'])->get(),
            'accounts'=>Lease::where('status',true)->with(['unit','masterfile'])->get()
        ]);
    }

    /**
     * Show the form for creating a new PaymentTransfer.
     *
     * @return Response
     */
    public function create()
    {
        return view('payment_transfers.create');
    }

    /**
     * Store a newly created PaymentTransfer in storage.
     *
     * @param CreatePaymentTransferRequest $request
     *
     * @return Response
     */
    public function store(CreatePaymentTransferRequest $request)
    {
        $input = $request->all();

        //get payment
        $payment =Payment::find($request->payment_id);

        //get lease
        $lease = Lease::find($request->lease_id);
        DB::transaction(function()use ($lease,$payment){
            if(!is_null($payment) && !is_null($lease)){
                $customerAccount = CustomerAccount::where('payment_id',$payment->id)->first();
                //updates
                $tFrom = $payment->house_number;
                $payment->house_number = $lease->unit_id;
                $payment->tenant_id = $lease->tenant_id;
                $payment->transferred_from = $tFrom;
                $payment->transfered_by = Auth::user()->name;
                $payment->save();

                $customerAccount->unit_id = $lease->unit_id;
                $customerAccount->lease_id = $lease->id;
                $customerAccount->tenant_id = $lease->tenant_id;
//                $customerAccount->state = 'TRANSFERRED';
                $customerAccount->save();
            }
        });


        Flash::success('Payment Transfer saved successfully.');

        return redirect(route('paymentTransfers.index'));
    }

    /**
     * Display the specified PaymentTransfer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $paymentTransfer = $this->paymentTransferRepository->findWithoutFail($id);

        if (empty($paymentTransfer)) {
            Flash::error('Payment Transfer not found');

            return redirect(route('paymentTransfers.index'));
        }

        return view('payment_transfers.show')->with('paymentTransfer', $paymentTransfer);
    }

    /**
     * Show the form for editing the specified PaymentTransfer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $paymentTransfer = $this->paymentTransferRepository->findWithoutFail($id);

        if (empty($paymentTransfer)) {
            Flash::error('Payment Transfer not found');

            return redirect(route('paymentTransfers.index'));
        }

        return view('payment_transfers.edit')->with('paymentTransfer', $paymentTransfer);
    }

    /**
     * Update the specified PaymentTransfer in storage.
     *
     * @param  int              $id
     * @param UpdatePaymentTransferRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePaymentTransferRequest $request)
    {
        $paymentTransfer = $this->paymentTransferRepository->findWithoutFail($id);

        if (empty($paymentTransfer)) {
            Flash::error('Payment Transfer not found');

            return redirect(route('paymentTransfers.index'));
        }

        $paymentTransfer = $this->paymentTransferRepository->update($request->all(), $id);

        Flash::success('Payment Transfer updated successfully.');

        return redirect(route('paymentTransfers.index'));
    }

    /**
     * Remove the specified PaymentTransfer from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $paymentTransfer = $this->paymentTransferRepository->findWithoutFail($id);

        if (empty($paymentTransfer)) {
            Flash::error('Payment Transfer not found');

            return redirect(route('paymentTransfers.index'));
        }

        $this->paymentTransferRepository->delete($id);

        Flash::success('Payment Transfer deleted successfully.');

        return redirect(route('paymentTransfers.index'));
    }
}
