<?php

namespace App\Http\Controllers;

use App\DataTables\BillDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateBillRequest;
use App\Http\Requests\UpdateBillRequest;
use App\Repositories\BillRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class BillController extends AppBaseController
{
    /** @var  BillRepository */
    private $billRepository;

    public function __construct(BillRepository $billRepo)
    {
        $this->middleware('auth');
        $this->billRepository = $billRepo;
    }

    /**
     * Display a listing of the Bill.
     *
     * @param BillDataTable $billDataTable
     * @return Response
     */
    public function index(BillDataTable $billDataTable)
    {
        return $billDataTable->render('bills.index');
    }

    /**
     * Show the form for creating a new Bill.
     *
     * @return Response
     */
    public function create()
    {
        return view('bills.create');
    }

    /**
     * Store a newly created Bill in storage.
     *
     * @param CreateBillRequest $request
     *
     * @return Response
     */
    public function store(CreateBillRequest $request)
    {
        $input = $request->all();

        $bill = $this->billRepository->create($input);

        Flash::success('Bill saved successfully.');

        return redirect(route('bills.index'));
    }

    /**
     * Display the specified Bill.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bill = $this->billRepository->findWithoutFail($id);

        if (empty($bill)) {
            Flash::error('Bill not found');

            return redirect(route('bills.index'));
        }

        return view('bills.show')->with('bill', $bill);
    }

    /**
     * Show the form for editing the specified Bill.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bill = $this->billRepository->findWithoutFail($id);

        if (empty($bill)) {
            Flash::error('Bill not found');

            return redirect(route('bills.index'));
        }

        return view('bills.edit')->with('bill', $bill);
    }

    /**
     * Update the specified Bill in storage.
     *
     * @param  int              $id
     * @param UpdateBillRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBillRequest $request)
    {
        $bill = $this->billRepository->findWithoutFail($id);

        if (empty($bill)) {
            Flash::error('Bill not found');

            return redirect(route('bills.index'));
        }

        $bill = $this->billRepository->update($request->all(), $id);

        Flash::success('Bill updated successfully.');

        return redirect(route('bills.index'));
    }

    /**
     * Remove the specified Bill from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bill = $this->billRepository->findWithoutFail($id);

        if (empty($bill)) {
            Flash::error('Bill not found');

            return redirect(route('bills.index'));
        }

        $this->billRepository->delete($id);

        Flash::success('Bill deleted successfully.');

        return redirect(route('bills.index'));
    }
}
