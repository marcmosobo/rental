<?php

namespace App\Http\Controllers;

use App\DataTables\OfficeExpenditureDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateOfficeExpenditureRequest;
use App\Http\Requests\UpdateOfficeExpenditureRequest;
use App\Repositories\OfficeExpenditureRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class OfficeExpenditureController extends AppBaseController
{
    /** @var  OfficeExpenditureRepository */
    private $officeExpenditureRepository;

    public function __construct(OfficeExpenditureRepository $officeExpenditureRepo)
    {
        $this->middleware('auth');
        $this->officeExpenditureRepository = $officeExpenditureRepo;
    }

    /**
     * Display a listing of the OfficeExpenditure.
     *
     * @param OfficeExpenditureDataTable $officeExpenditureDataTable
     * @return Response
     */
    public function index(OfficeExpenditureDataTable $officeExpenditureDataTable)
    {
        return $officeExpenditureDataTable->render('office_expenditures.index');
    }

    /**
     * Show the form for creating a new OfficeExpenditure.
     *
     * @return Response
     */
    public function create()
    {
        return view('office_expenditures.create');
    }

    /**
     * Store a newly created OfficeExpenditure in storage.
     *
     * @param CreateOfficeExpenditureRequest $request
     *
     * @return Response
     */
    public function store(CreateOfficeExpenditureRequest $request)
    {
        $input = $request->all();

        $officeExpenditure = $this->officeExpenditureRepository->create($input);

        Flash::success('Office Expenditure saved successfully.');

        return redirect(route('officeExpenditures.index'));
    }

    /**
     * Display the specified OfficeExpenditure.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $officeExpenditure = $this->officeExpenditureRepository->findWithoutFail($id);

        if (empty($officeExpenditure)) {
            Flash::error('Office Expenditure not found');

            return redirect(route('officeExpenditures.index'));
        }

        return response()->json($officeExpenditure);
    }

    /**
     * Show the form for editing the specified OfficeExpenditure.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $officeExpenditure = $this->officeExpenditureRepository->findWithoutFail($id);

        if (empty($officeExpenditure)) {
            Flash::error('Office Expenditure not found');

            return redirect(route('officeExpenditures.index'));
        }

        return view('office_expenditures.edit')->with('officeExpenditure', $officeExpenditure);
    }

    /**
     * Update the specified OfficeExpenditure in storage.
     *
     * @param  int              $id
     * @param UpdateOfficeExpenditureRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOfficeExpenditureRequest $request)
    {
        $officeExpenditure = $this->officeExpenditureRepository->findWithoutFail($id);

        if (empty($officeExpenditure)) {
            Flash::error('Office Expenditure not found');

            return redirect(route('officeExpenditures.index'));
        }

        $officeExpenditure = $this->officeExpenditureRepository->update($request->all(), $id);

        Flash::success('Office Expenditure updated successfully.');

        return redirect(route('officeExpenditures.index'));
    }

    /**
     * Remove the specified OfficeExpenditure from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $officeExpenditure = $this->officeExpenditureRepository->findWithoutFail($id);

        if (empty($officeExpenditure)) {
            Flash::error('Office Expenditure not found');

            return redirect(route('officeExpenditures.index'));
        }

        $this->officeExpenditureRepository->delete($id);

        Flash::success('Office Expenditure deleted successfully.');

        return redirect(route('officeExpenditures.index'));
    }
}
