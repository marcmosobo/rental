<?php

namespace App\Http\Controllers;

use App\DataTables\CustomerMessageDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCustomerMessageRequest;
use App\Http\Requests\UpdateCustomerMessageRequest;
use App\Jobs\SendSms;
use App\Models\Masterfile;
use App\Repositories\CustomerMessageRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CustomerMessageController extends AppBaseController
{
    /** @var  CustomerMessageRepository */
    private $customerMessageRepository;

    public function __construct(CustomerMessageRepository $customerMessageRepo)
    {
        $this->middleware('auth');
        $this->customerMessageRepository = $customerMessageRepo;
    }

    /**
     * Display a listing of the CustomerMessage.
     *
     * @param CustomerMessageDataTable $customerMessageDataTable
     * @return Response
     */
    public function index(CustomerMessageDataTable $customerMessageDataTable)
    {
        return $customerMessageDataTable->render('customer_messages.index',[
            'recipients'=>Masterfile::where('b_role',tenant)->get()
        ]);
    }

    /**
     * Show the form for creating a new CustomerMessage.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer_messages.create');
    }

    /**
     * Store a newly created CustomerMessage in storage.
     *
     * @param CreateCustomerMessageRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerMessageRequest $request)
    {
        $input = $request->all();
        $mf = Masterfile::find($request->recipient);

        SendSms::dispatch($request->message,$mf->phone_number,$mf);

//        $customerMessage = $this->customerMessageRepository->create($input);

        Flash::success('Customer Message queued for sending.');

        return redirect(route('customerMessages.index'));
    }

    /**
     * Display the specified CustomerMessage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerMessage = $this->customerMessageRepository->findWithoutFail($id);

        if (empty($customerMessage)) {
            Flash::error('Customer Message not found');

            return redirect(route('customerMessages.index'));
        }

        return view('customer_messages.show')->with('customerMessage', $customerMessage);
    }

    /**
     * Show the form for editing the specified CustomerMessage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerMessage = $this->customerMessageRepository->findWithoutFail($id);

        if (empty($customerMessage)) {
            Flash::error('Customer Message not found');

            return redirect(route('customerMessages.index'));
        }

        return view('customer_messages.edit')->with('customerMessage', $customerMessage);
    }

    /**
     * Update the specified CustomerMessage in storage.
     *
     * @param  int              $id
     * @param UpdateCustomerMessageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerMessageRequest $request)
    {
        $customerMessage = $this->customerMessageRepository->findWithoutFail($id);

        if (empty($customerMessage)) {
            Flash::error('Customer Message not found');

            return redirect(route('customerMessages.index'));
        }

        $customerMessage = $this->customerMessageRepository->update($request->all(), $id);

        Flash::success('Customer Message updated successfully.');

        return redirect(route('customerMessages.index'));
    }

    /**
     * Remove the specified CustomerMessage from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerMessage = $this->customerMessageRepository->findWithoutFail($id);

        if (empty($customerMessage)) {
            Flash::error('Customer Message not found');

            return redirect(route('customerMessages.index'));
        }

        $this->customerMessageRepository->delete($id);

        Flash::success('Customer Message deleted successfully.');

        return redirect(route('customerMessages.index'));
    }
}
