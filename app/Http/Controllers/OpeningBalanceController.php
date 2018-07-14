<?php

namespace App\Http\Controllers;

use App\DataTables\OpeningBalanceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateOpeningBalanceRequest;
use App\Http\Requests\UpdateOpeningBalanceRequest;
use App\Models\Masterfile;
use App\Repositories\OpeningBalanceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class OpeningBalanceController extends AppBaseController
{
    /** @var  OpeningBalanceRepository */
    private $openingBalanceRepository;

    public function __construct(OpeningBalanceRepository $openingBalanceRepo)
    {
        $this->middleware('auth');
        $this->openingBalanceRepository = $openingBalanceRepo;
    }

    /**
     * Display a listing of the OpeningBalance.
     *
     * @param OpeningBalanceDataTable $openingBalanceDataTable
     * @return Response
     */
    public function index(OpeningBalanceDataTable $openingBalanceDataTable)
    {
        return $openingBalanceDataTable->render('opening_balances.index',[
            'landlords'=>Masterfile::where('b_role',landlord)->get()
        ]);
    }

    /**
     * Show the form for creating a new OpeningBalance.
     *
     * @return Response
     */
    public function create()
    {
        return view('opening_balances.create');
    }

    /**
     * Store a newly created OpeningBalance in storage.
     *
     * @param CreateOpeningBalanceRequest $request
     *
     * @return Response
     */
    public function store(CreateOpeningBalanceRequest $request)
    {
        $input = $request->all();

        $openingBalance = $this->openingBalanceRepository->create($input);

        Flash::success('Opening Balance saved successfully.');

        return redirect(route('openingBalances.index'));
    }

    /**
     * Display the specified OpeningBalance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $openingBalance = $this->openingBalanceRepository->findWithoutFail($id);

        if (empty($openingBalance)) {
            Flash::error('Opening Balance not found');

            return redirect(route('openingBalances.index'));
        }

        return response()->json($openingBalance);
    }

    /**
     * Show the form for editing the specified OpeningBalance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $openingBalance = $this->openingBalanceRepository->findWithoutFail($id);

        if (empty($openingBalance)) {
            Flash::error('Opening Balance not found');

            return redirect(route('openingBalances.index'));
        }

        return view('opening_balances.edit')->with('openingBalance', $openingBalance);
    }

    /**
     * Update the specified OpeningBalance in storage.
     *
     * @param  int              $id
     * @param UpdateOpeningBalanceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOpeningBalanceRequest $request)
    {
        $openingBalance = $this->openingBalanceRepository->findWithoutFail($id);

        if (empty($openingBalance)) {
            Flash::error('Opening Balance not found');

            return redirect(route('openingBalances.index'));
        }

        $openingBalance = $this->openingBalanceRepository->update($request->all(), $id);

        Flash::success('Opening Balance updated successfully.');

        return redirect(route('openingBalances.index'));
    }

    /**
     * Remove the specified OpeningBalance from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $openingBalance = $this->openingBalanceRepository->findWithoutFail($id);

        if (empty($openingBalance)) {
            Flash::error('Opening Balance not found');

            return redirect(route('openingBalances.index'));
        }

        $this->openingBalanceRepository->delete($id);

        Flash::success('Opening Balance deleted successfully.');

        return redirect(route('openingBalances.index'));
    }
}
