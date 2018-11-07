<?php

namespace App\Http\Controllers;

use App\DataTables\SplitPaymentsDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSplitPaymentsRequest;
use App\Http\Requests\UpdateSplitPaymentsRequest;
use App\Models\CustomerAccount;
use App\Models\Lease;
use App\Models\Masterfile;
use App\Models\Payment;
use App\Models\PropertyUnit;
use App\Repositories\SplitPaymentsRepository;
use Carbon\Carbon;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
//        print_r($input);die;

        DB::transaction(function()use ($input){
            $splitPayments = Payment::find($input['payment_id']);
            $input['payment_mode'] = mpesa;
            $input['house_number'] = $input['service_account'];
            $input['received_on'] = $splitPayments->received_on;
            $input['created_by'] = Auth::user()->mf_id;
            $input['TransID'] = 'SPLIT';
            $payment = $this->splitPaymentsRepository->create($input);


            if(!is_null($payment->house_number )) {
                $propertyUnit = PropertyUnit::where('unit_number', $payment->house_number)->first();
//            print_r($propertyUnit);die;
                if (!is_null($propertyUnit)) {
                    //get lease
                    $lease = Lease::where('unit_id', $propertyUnit->id)
                        ->where('status', true)->first();
                    if (is_null($lease)) {
                        $lease = Lease::where('unit_id', $propertyUnit->id)->orderByDesc('id')->first();
                    }
//
                    if(!is_null($lease)) {
                        //get tenant
                        $tenant = Masterfile::find($lease->tenant_id);
                        $input['client_id'] = $tenant->client_id;
                        $input['mf_id'] = $tenant->id;

                            if(is_null(CustomerAccount::where('ref_number',$payment->ref_number)->first())){
                                $acc = CustomerAccount::create([
                                    'tenant_id' => $tenant->id,
                                    'lease_id' => $lease->id,
                                    'unit_id' => $propertyUnit->id,
                                    'payment_id' => $payment->id,
                                    'ref_number' => $payment->ref_number,
                                    'transaction_type' => debit,
                                    'amount' => $payment->amount,
                                    'date' => $splitPayments->received_on
                                ]);

                                $payment->status = true;
                                $payment->house_number = $propertyUnit->unit_number;
                                $payment->tenant_id = $tenant->id;
                                $payment->client_id = $input['client_id'];
                                $payment->save();

                                $splitPayments->amount -= $input['amount'];
                                $splitPayments->save();
                            }

                    }else{
                        Flash::error('This house has no active lease');
                        return redirect(route('payments.index'));
                    }
                }
            }else{
                Flash::error('You must choose house number.');
                return redirect(route('unprocessedPayments.index'));
            }

        });



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
