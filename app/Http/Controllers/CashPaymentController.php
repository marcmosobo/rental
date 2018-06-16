<?php

namespace App\Http\Controllers;

use App\DataTables\CashPaymentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCashPaymentRequest;
use App\Http\Requests\UpdateCashPaymentRequest;
use App\Repositories\CashPaymentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CashPaymentController extends AppBaseController
{
    /** @var  CashPaymentRepository */
    private $cashPaymentRepository;

    public function __construct(CashPaymentRepository $cashPaymentRepo)
    {
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
        return $cashPaymentDataTable->render('cash_payments.index');
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

        $cashPayment = $this->cashPaymentRepository->create($input);

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

        return view('cash_payments.show')->with('cashPayment', $cashPayment);
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

        $cashPayment = $this->cashPaymentRepository->update($request->all(), $id);

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
