<?php

namespace App\Http\Controllers;

use App\DataTables\LandlordAccountDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLandlordAccountRequest;
use App\Http\Requests\UpdateLandlordAccountRequest;
use App\Repositories\LandlordAccountRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class LandlordAccountController extends AppBaseController
{
    /** @var  LandlordAccountRepository */
    private $landlordAccountRepository;

    public function __construct(LandlordAccountRepository $landlordAccountRepo)
    {
        $this->landlordAccountRepository = $landlordAccountRepo;
    }

    /**
     * Display a listing of the LandlordAccount.
     *
     * @param LandlordAccountDataTable $landlordAccountDataTable
     * @return Response
     */
    public function index(LandlordAccountDataTable $landlordAccountDataTable)
    {
        return $landlordAccountDataTable->render('landlord_accounts.index');
    }

    /**
     * Show the form for creating a new LandlordAccount.
     *
     * @return Response
     */
    public function create()
    {
        return view('landlord_accounts.create');
    }

    /**
     * Store a newly created LandlordAccount in storage.
     *
     * @param CreateLandlordAccountRequest $request
     *
     * @return Response
     */
    public function store(CreateLandlordAccountRequest $request)
    {
        $input = $request->all();

        $landlordAccount = $this->landlordAccountRepository->create($input);

        Flash::success('Landlord Account saved successfully.');

        return redirect(route('landlordAccounts.index'));
    }

    /**
     * Display the specified LandlordAccount.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $landlordAccount = $this->landlordAccountRepository->findWithoutFail($id);

        if (empty($landlordAccount)) {
            Flash::error('Landlord Account not found');

            return redirect(route('landlordAccounts.index'));
        }

        return view('landlord_accounts.show')->with('landlordAccount', $landlordAccount);
    }

    /**
     * Show the form for editing the specified LandlordAccount.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $landlordAccount = $this->landlordAccountRepository->findWithoutFail($id);

        if (empty($landlordAccount)) {
            Flash::error('Landlord Account not found');

            return redirect(route('landlordAccounts.index'));
        }

        return view('landlord_accounts.edit')->with('landlordAccount', $landlordAccount);
    }

    /**
     * Update the specified LandlordAccount in storage.
     *
     * @param  int              $id
     * @param UpdateLandlordAccountRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLandlordAccountRequest $request)
    {
        $landlordAccount = $this->landlordAccountRepository->findWithoutFail($id);

        if (empty($landlordAccount)) {
            Flash::error('Landlord Account not found');

            return redirect(route('landlordAccounts.index'));
        }

        $landlordAccount = $this->landlordAccountRepository->update($request->all(), $id);

        Flash::success('Landlord Account updated successfully.');

        return redirect(route('landlordAccounts.index'));
    }

    /**
     * Remove the specified LandlordAccount from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $landlordAccount = $this->landlordAccountRepository->findWithoutFail($id);

        if (empty($landlordAccount)) {
            Flash::error('Landlord Account not found');

            return redirect(route('landlordAccounts.index'));
        }

        $this->landlordAccountRepository->delete($id);

        Flash::success('Landlord Account deleted successfully.');

        return redirect(route('landlordAccounts.index'));
    }
}
