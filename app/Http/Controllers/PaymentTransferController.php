<?php

namespace App\Http\Controllers;

use App\DataTables\PaymentTransferDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePaymentTransferRequest;
use App\Http\Requests\UpdatePaymentTransferRequest;
use App\Repositories\PaymentTransferRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
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
        return $paymentTransferDataTable->render('payment_transfers.index');
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

        $paymentTransfer = $this->paymentTransferRepository->create($input);

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
