<?php

namespace App\Http\Controllers;

use App\DataTables\DepositRefundDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateDepositRefundRequest;
use App\Http\Requests\UpdateDepositRefundRequest;
use App\Repositories\DepositRefundRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class DepositRefundController extends AppBaseController
{
    /** @var  DepositRefundRepository */
    private $depositRefundRepository;

    public function __construct(DepositRefundRepository $depositRefundRepo)
    {
        $this->middleware('auth');
        $this->depositRefundRepository = $depositRefundRepo;
    }

    /**
     * Display a listing of the DepositRefund.
     *
     * @param DepositRefundDataTable $depositRefundDataTable
     * @return Response
     */
    public function index(DepositRefundDataTable $depositRefundDataTable)
    {
        return $depositRefundDataTable->render('deposit_refunds.index');
    }

    /**
     * Show the form for creating a new DepositRefund.
     *
     * @return Response
     */
    public function create()
    {
        return view('deposit_refunds.create');
    }

    /**
     * Store a newly created DepositRefund in storage.
     *
     * @param CreateDepositRefundRequest $request
     *
     * @return Response
     */
    public function store(CreateDepositRefundRequest $request)
    {
        $input = $request->all();

        $depositRefund = $this->depositRefundRepository->create($input);

        Flash::success('Deposit Refund saved successfully.');

        return redirect(route('depositRefunds.index'));
    }

    /**
     * Display the specified DepositRefund.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $depositRefund = $this->depositRefundRepository->findWithoutFail($id);

        if (empty($depositRefund)) {
            Flash::error('Deposit Refund not found');

            return redirect(route('depositRefunds.index'));
        }

        return view('deposit_refunds.show')->with('depositRefund', $depositRefund);
    }

    /**
     * Show the form for editing the specified DepositRefund.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $depositRefund = $this->depositRefundRepository->findWithoutFail($id);

        if (empty($depositRefund)) {
            Flash::error('Deposit Refund not found');

            return redirect(route('depositRefunds.index'));
        }

        return view('deposit_refunds.edit')->with('depositRefund', $depositRefund);
    }

    /**
     * Update the specified DepositRefund in storage.
     *
     * @param  int              $id
     * @param UpdateDepositRefundRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepositRefundRequest $request)
    {
        $depositRefund = $this->depositRefundRepository->findWithoutFail($id);

        if (empty($depositRefund)) {
            Flash::error('Deposit Refund not found');

            return redirect(route('depositRefunds.index'));
        }

        $depositRefund = $this->depositRefundRepository->update($request->all(), $id);

        Flash::success('Deposit Refund updated successfully.');

        return redirect(route('depositRefunds.index'));
    }

    /**
     * Remove the specified DepositRefund from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $depositRefund = $this->depositRefundRepository->findWithoutFail($id);

        if (empty($depositRefund)) {
            Flash::error('Deposit Refund not found');

            return redirect(route('depositRefunds.index'));
        }

        $this->depositRefundRepository->delete($id);

        Flash::success('Deposit Refund deleted successfully.');

        return redirect(route('depositRefunds.index'));
    }
}
