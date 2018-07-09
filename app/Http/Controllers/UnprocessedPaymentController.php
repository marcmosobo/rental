<?php

namespace App\Http\Controllers;

use App\DataTables\UnprocessedPaymentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUnprocessedPaymentRequest;
use App\Http\Requests\UpdateUnprocessedPaymentRequest;
use App\Repositories\UnprocessedPaymentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class UnprocessedPaymentController extends AppBaseController
{
    /** @var  UnprocessedPaymentRepository */
    private $unprocessedPaymentRepository;

    public function __construct(UnprocessedPaymentRepository $unprocessedPaymentRepo)
    {
        $this->unprocessedPaymentRepository = $unprocessedPaymentRepo;
    }

    /**
     * Display a listing of the UnprocessedPayment.
     *
     * @param UnprocessedPaymentDataTable $unprocessedPaymentDataTable
     * @return Response
     */
    public function index(UnprocessedPaymentDataTable $unprocessedPaymentDataTable)
    {
        return $unprocessedPaymentDataTable->render('unprocessed_payments.index');
    }

    /**
     * Show the form for creating a new UnprocessedPayment.
     *
     * @return Response
     */
    public function create()
    {
        return view('unprocessed_payments.create');
    }

    /**
     * Store a newly created UnprocessedPayment in storage.
     *
     * @param CreateUnprocessedPaymentRequest $request
     *
     * @return Response
     */
    public function store(CreateUnprocessedPaymentRequest $request)
    {
        $input = $request->all();

        $unprocessedPayment = $this->unprocessedPaymentRepository->create($input);

        Flash::success('Unprocessed Payment saved successfully.');

        return redirect(route('unprocessedPayments.index'));
    }

    /**
     * Display the specified UnprocessedPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $unprocessedPayment = $this->unprocessedPaymentRepository->findWithoutFail($id);

        if (empty($unprocessedPayment)) {
            Flash::error('Unprocessed Payment not found');

            return redirect(route('unprocessedPayments.index'));
        }

        return view('unprocessed_payments.show')->with('unprocessedPayment', $unprocessedPayment);
    }

    /**
     * Show the form for editing the specified UnprocessedPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $unprocessedPayment = $this->unprocessedPaymentRepository->findWithoutFail($id);

        if (empty($unprocessedPayment)) {
            Flash::error('Unprocessed Payment not found');

            return redirect(route('unprocessedPayments.index'));
        }

        return view('unprocessed_payments.edit')->with('unprocessedPayment', $unprocessedPayment);
    }

    /**
     * Update the specified UnprocessedPayment in storage.
     *
     * @param  int              $id
     * @param UpdateUnprocessedPaymentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUnprocessedPaymentRequest $request)
    {
        $unprocessedPayment = $this->unprocessedPaymentRepository->findWithoutFail($id);

        if (empty($unprocessedPayment)) {
            Flash::error('Unprocessed Payment not found');

            return redirect(route('unprocessedPayments.index'));
        }

        $unprocessedPayment = $this->unprocessedPaymentRepository->update($request->all(), $id);

        Flash::success('Unprocessed Payment updated successfully.');

        return redirect(route('unprocessedPayments.index'));
    }

    /**
     * Remove the specified UnprocessedPayment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $unprocessedPayment = $this->unprocessedPaymentRepository->findWithoutFail($id);

        if (empty($unprocessedPayment)) {
            Flash::error('Unprocessed Payment not found');

            return redirect(route('unprocessedPayments.index'));
        }

        $this->unprocessedPaymentRepository->delete($id);

        Flash::success('Unprocessed Payment deleted successfully.');

        return redirect(route('unprocessedPayments.index'));
    }
}
