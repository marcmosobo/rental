<?php

namespace App\Http\Controllers;

use App\DataTables\InterestRateDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateInterestRateRequest;
use App\Http\Requests\UpdateInterestRateRequest;
use App\Repositories\InterestRateRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class InterestRateController extends AppBaseController
{
    /** @var  InterestRateRepository */
    private $interestRateRepository;

    public function __construct(InterestRateRepository $interestRateRepo)
    {
        $this->middleware('auth');
        $this->interestRateRepository = $interestRateRepo;
    }

    /**
     * Display a listing of the InterestRate.
     *
     * @param InterestRateDataTable $interestRateDataTable
     * @return Response
     */
    public function index(InterestRateDataTable $interestRateDataTable)
    {
        return $interestRateDataTable->render('interest_rates.index');
    }

    /**
     * Show the form for creating a new InterestRate.
     *
     * @return Response
     */
    public function create()
    {
        return view('interest_rates.create');
    }

    /**
     * Store a newly created InterestRate in storage.
     *
     * @param CreateInterestRateRequest $request
     *
     * @return Response
     */
    public function store(CreateInterestRateRequest $request)
    {
        $input = $request->all();

        $interestRate = $this->interestRateRepository->create($input);

        Flash::success('Interest Rate saved successfully.');

        return redirect(route('interestRates.index'));
    }

    /**
     * Display the specified InterestRate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $interestRate = $this->interestRateRepository->findWithoutFail($id);

        if (empty($interestRate)) {
            Flash::error('Interest Rate not found');

            return redirect(route('interestRates.index'));
        }

        return response()->json($interestRate);
    }

    /**
     * Show the form for editing the specified InterestRate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $interestRate = $this->interestRateRepository->findWithoutFail($id);

        if (empty($interestRate)) {
            Flash::error('Interest Rate not found');

            return redirect(route('interestRates.index'));
        }

        return view('interest_rates.edit')->with('interestRate', $interestRate);
    }

    /**
     * Update the specified InterestRate in storage.
     *
     * @param  int              $id
     * @param UpdateInterestRateRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInterestRateRequest $request)
    {
        $interestRate = $this->interestRateRepository->findWithoutFail($id);

        if (empty($interestRate)) {
            Flash::error('Interest Rate not found');

            return redirect(route('interestRates.index'));
        }

        $interestRate = $this->interestRateRepository->update($request->all(), $id);

        Flash::success('Interest Rate updated successfully.');

        return redirect(route('interestRates.index'));
    }

    /**
     * Remove the specified InterestRate from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $interestRate = $this->interestRateRepository->findWithoutFail($id);

        if (empty($interestRate)) {
            Flash::error('Interest Rate not found');

            return redirect(route('interestRates.index'));
        }

        $this->interestRateRepository->delete($id);

        Flash::success('Interest Rate deleted successfully.');

        return redirect(route('interestRates.index'));
    }
}
