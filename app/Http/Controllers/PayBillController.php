<?php

namespace App\Http\Controllers;

use App\DataTables\PayBillDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePayBillRequest;
use App\Http\Requests\UpdatePayBillRequest;
use App\Repositories\PayBillRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PayBillController extends AppBaseController
{
    /** @var  PayBillRepository */
    private $payBillRepository;

    public function __construct(PayBillRepository $payBillRepo)
    {
        $this->payBillRepository = $payBillRepo;
    }

    /**
     * Display a listing of the PayBill.
     *
     * @param PayBillDataTable $payBillDataTable
     * @return Response
     */
    public function index(PayBillDataTable $payBillDataTable)
    {
        return $payBillDataTable->render('pay_bills.index');
    }

    /**
     * Show the form for creating a new PayBill.
     *
     * @return Response
     */
    public function create()
    {
        return view('pay_bills.create');
    }

    /**
     * Store a newly created PayBill in storage.
     *
     * @param CreatePayBillRequest $request
     *
     * @return Response
     */
    public function store(CreatePayBillRequest $request)
    {
        $input = $request->all();

        $payBill = $this->payBillRepository->create($input);

        Flash::success('Pay Bill saved successfully.');

        return redirect(route('payBills.index'));
    }

    /**
     * Display the specified PayBill.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $payBill = $this->payBillRepository->findWithoutFail($id);

        if (empty($payBill)) {
            Flash::error('Pay Bill not found');

            return redirect(route('payBills.index'));
        }

        return view('pay_bills.show')->with('payBill', $payBill);
    }

    /**
     * Show the form for editing the specified PayBill.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $payBill = $this->payBillRepository->findWithoutFail($id);

        if (empty($payBill)) {
            Flash::error('Pay Bill not found');

            return redirect(route('payBills.index'));
        }

        return view('pay_bills.edit')->with('payBill', $payBill);
    }

    /**
     * Update the specified PayBill in storage.
     *
     * @param  int              $id
     * @param UpdatePayBillRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePayBillRequest $request)
    {
        $payBill = $this->payBillRepository->findWithoutFail($id);

        if (empty($payBill)) {
            Flash::error('Pay Bill not found');

            return redirect(route('payBills.index'));
        }

        $payBill = $this->payBillRepository->update($request->all(), $id);

        Flash::success('Pay Bill updated successfully.');

        return redirect(route('payBills.index'));
    }

    /**
     * Remove the specified PayBill from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $payBill = $this->payBillRepository->findWithoutFail($id);

        if (empty($payBill)) {
            Flash::error('Pay Bill not found');

            return redirect(route('payBills.index'));
        }

        $this->payBillRepository->delete($id);

        Flash::success('Pay Bill deleted successfully.');

        return redirect(route('payBills.index'));
    }
}
