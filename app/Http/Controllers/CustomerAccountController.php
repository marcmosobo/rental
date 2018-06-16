<?php

namespace App\Http\Controllers;

use App\DataTables\CustomerAccountDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCustomerAccountRequest;
use App\Http\Requests\UpdateCustomerAccountRequest;
use App\Repositories\CustomerAccountRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CustomerAccountController extends AppBaseController
{
    /** @var  CustomerAccountRepository */
    private $customerAccountRepository;

    public function __construct(CustomerAccountRepository $customerAccountRepo)
    {
        $this->customerAccountRepository = $customerAccountRepo;
    }

    /**
     * Display a listing of the CustomerAccount.
     *
     * @param CustomerAccountDataTable $customerAccountDataTable
     * @return Response
     */
    public function index(CustomerAccountDataTable $customerAccountDataTable)
    {
        return $customerAccountDataTable->render('customer_accounts.index');
    }

    /**
     * Show the form for creating a new CustomerAccount.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer_accounts.create');
    }

    /**
     * Store a newly created CustomerAccount in storage.
     *
     * @param CreateCustomerAccountRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerAccountRequest $request)
    {
        $input = $request->all();

        $customerAccount = $this->customerAccountRepository->create($input);

        Flash::success('Customer Account saved successfully.');

        return redirect(route('customerAccounts.index'));
    }

    /**
     * Display the specified CustomerAccount.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerAccount = $this->customerAccountRepository->findWithoutFail($id);

        if (empty($customerAccount)) {
            Flash::error('Customer Account not found');

            return redirect(route('customerAccounts.index'));
        }

        return view('customer_accounts.show')->with('customerAccount', $customerAccount);
    }

    /**
     * Show the form for editing the specified CustomerAccount.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerAccount = $this->customerAccountRepository->findWithoutFail($id);

        if (empty($customerAccount)) {
            Flash::error('Customer Account not found');

            return redirect(route('customerAccounts.index'));
        }

        return view('customer_accounts.edit')->with('customerAccount', $customerAccount);
    }

    /**
     * Update the specified CustomerAccount in storage.
     *
     * @param  int              $id
     * @param UpdateCustomerAccountRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerAccountRequest $request)
    {
        $customerAccount = $this->customerAccountRepository->findWithoutFail($id);

        if (empty($customerAccount)) {
            Flash::error('Customer Account not found');

            return redirect(route('customerAccounts.index'));
        }

        $customerAccount = $this->customerAccountRepository->update($request->all(), $id);

        Flash::success('Customer Account updated successfully.');

        return redirect(route('customerAccounts.index'));
    }

    /**
     * Remove the specified CustomerAccount from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerAccount = $this->customerAccountRepository->findWithoutFail($id);

        if (empty($customerAccount)) {
            Flash::error('Customer Account not found');

            return redirect(route('customerAccounts.index'));
        }

        $this->customerAccountRepository->delete($id);

        Flash::success('Customer Account deleted successfully.');

        return redirect(route('customerAccounts.index'));
    }
}
