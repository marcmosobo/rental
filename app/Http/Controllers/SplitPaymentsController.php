<?php

namespace App\Http\Controllers;

use App\DataTables\SplitPaymentsDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSplitPaymentsRequest;
use App\Http\Requests\UpdateSplitPaymentsRequest;
use App\Repositories\SplitPaymentsRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class SplitPaymentsController extends AppBaseController
{
    /** @var  SplitPaymentsRepository */
    private $splitPaymentsRepository;

    public function __construct(SplitPaymentsRepository $splitPaymentsRepo)
    {
        $this->middleware('auth');
        $this->splitPaymentsRepository = $splitPaymentsRepo;
    }

    /**
     * Display a listing of the SplitPayments.
     *
     * @param SplitPaymentsDataTable $splitPaymentsDataTable
     * @return Response
     */
    public function index(SplitPaymentsDataTable $splitPaymentsDataTable)
    {
        return $splitPaymentsDataTable->render('split_payments.index');
    }

    /**
     * Show the form for creating a new SplitPayments.
     *
     * @return Response
     */
    public function create()
    {
        return view('split_payments.create');
    }

    /**
     * Store a newly created SplitPayments in storage.
     *
     * @param CreateSplitPaymentsRequest $request
     *
     * @return Response
     */
    public function store(CreateSplitPaymentsRequest $request)
    {
        $input = $request->all();

        $splitPayments = $this->splitPaymentsRepository->create($input);

        Flash::success('Split Payments saved successfully.');

        return redirect(route('splitPayments.index'));
    }

    /**
     * Display the specified SplitPayments.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $splitPayments = $this->splitPaymentsRepository->findWithoutFail($id);

        if (empty($splitPayments)) {
            Flash::error('Split Payments not found');

            return redirect(route('splitPayments.index'));
        }

        return view('split_payments.show')->with('splitPayments', $splitPayments);
    }

    /**
     * Show the form for editing the specified SplitPayments.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $splitPayments = $this->splitPaymentsRepository->findWithoutFail($id);

        if (empty($splitPayments)) {
            Flash::error('Split Payments not found');

            return redirect(route('splitPayments.index'));
        }

        return view('split_payments.edit')->with('splitPayments', $splitPayments);
    }

    /**
     * Update the specified SplitPayments in storage.
     *
     * @param  int              $id
     * @param UpdateSplitPaymentsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSplitPaymentsRequest $request)
    {
        $splitPayments = $this->splitPaymentsRepository->findWithoutFail($id);

        if (empty($splitPayments)) {
            Flash::error('Split Payments not found');

            return redirect(route('splitPayments.index'));
        }

        $splitPayments = $this->splitPaymentsRepository->update($request->all(), $id);

        Flash::success('Split Payments updated successfully.');

        return redirect(route('splitPayments.index'));
    }

    /**
     * Remove the specified SplitPayments from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $splitPayments = $this->splitPaymentsRepository->findWithoutFail($id);

        if (empty($splitPayments)) {
            Flash::error('Split Payments not found');

            return redirect(route('splitPayments.index'));
        }

        $this->splitPaymentsRepository->delete($id);

        Flash::success('Split Payments deleted successfully.');

        return redirect(route('splitPayments.index'));
    }
}
