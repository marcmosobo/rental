<?php

namespace App\Http\Controllers;

use App\DataTables\ExpenditureDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateExpenditureRequest;
use App\Http\Requests\UpdateExpenditureRequest;
use App\Repositories\ExpenditureRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ExpenditureController extends AppBaseController
{
    /** @var  ExpenditureRepository */
    private $expenditureRepository;

    public function __construct(ExpenditureRepository $expenditureRepo)
    {
        $this->middleware('auth');
        $this->expenditureRepository = $expenditureRepo;
    }

    /**
     * Display a listing of the Expenditure.
     *
     * @param ExpenditureDataTable $expenditureDataTable
     * @return Response
     */
    public function index(ExpenditureDataTable $expenditureDataTable)
    {
        return $expenditureDataTable->render('expenditures.index');
    }

    /**
     * Show the form for creating a new Expenditure.
     *
     * @return Response
     */
    public function create()
    {
        return view('expenditures.create');
    }

    /**
     * Store a newly created Expenditure in storage.
     *
     * @param CreateExpenditureRequest $request
     *
     * @return Response
     */
    public function store(CreateExpenditureRequest $request)
    {
        $input = $request->all();

        $expenditure = $this->expenditureRepository->create($input);

        Flash::success('Expenditure saved successfully.');

        return redirect(route('expenditures.index'));
    }

    /**
     * Display the specified Expenditure.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $expenditure = $this->expenditureRepository->findWithoutFail($id);

        if (empty($expenditure)) {
            Flash::error('Expenditure not found');

            return redirect(route('expenditures.index'));
        }

        return response()->json($expenditure);
    }

    /**
     * Show the form for editing the specified Expenditure.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $expenditure = $this->expenditureRepository->findWithoutFail($id);

        if (empty($expenditure)) {
            Flash::error('Expenditure not found');

            return redirect(route('expenditures.index'));
        }

        return view('expenditures.edit')->with('expenditure', $expenditure);
    }

    /**
     * Update the specified Expenditure in storage.
     *
     * @param  int              $id
     * @param UpdateExpenditureRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExpenditureRequest $request)
    {
        $expenditure = $this->expenditureRepository->findWithoutFail($id);

        if (empty($expenditure)) {
            Flash::error('Expenditure not found');

            return redirect(route('expenditures.index'));
        }

        $expenditure = $this->expenditureRepository->update($request->all(), $id);

        Flash::success('Expenditure updated successfully.');

        return redirect(route('expenditures.index'));
    }

    /**
     * Remove the specified Expenditure from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $expenditure = $this->expenditureRepository->findWithoutFail($id);

        if (empty($expenditure)) {
            Flash::error('Expenditure not found');

            return redirect(route('expenditures.index'));
        }

        $this->expenditureRepository->delete($id);

        Flash::success('Expenditure deleted successfully.');

        return redirect(route('expenditures.index'));
    }
}
