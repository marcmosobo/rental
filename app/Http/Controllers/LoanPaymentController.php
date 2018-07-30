<?php

namespace App\Http\Controllers;

use App\DataTables\LoanPaymentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLoanPaymentRequest;
use App\Http\Requests\UpdateLoanPaymentRequest;
use App\Models\LandlordAccount;
use App\Models\Loan;
use App\Repositories\LoanPaymentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Response;

class LoanPaymentController extends AppBaseController
{
    /** @var  LoanPaymentRepository */
    private $loanPaymentRepository;

    public function __construct(LoanPaymentRepository $loanPaymentRepo)
    {
        $this->middleware('auth');
        $this->loanPaymentRepository = $loanPaymentRepo;
    }

    /**
     * Display a listing of the LoanPayment.
     *
     * @param LoanPaymentDataTable $loanPaymentDataTable
     * @return Response
     */
    public function index(LoanPaymentDataTable $loanPaymentDataTable)
    {
        return $loanPaymentDataTable->render('loan_payments.index',[
            'loans'=> Loan::where('status',false)->with(['masterfile'])->get()
        ]);
    }

    /**
     * Show the form for creating a new LoanPayment.
     *
     * @return Response
     */
    public function create()
    {
        return view('loan_payments.create');
    }

    /**
     * Store a newly created LoanPayment in storage.
     *
     * @param CreateLoanPaymentRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanPaymentRequest $request)
    {
        $input = $request->all();

        $account = LandlordAccount::where('loan_id',$request->loan_id)->get();
        $due = $account->where('transaction_type',credit)->sum('amount') - $account->where('transaction_type',debit)->sum('amount');
        if($input['amount'] > $due){
            Flash::error('You cannot pay more than the amount owed ('.$due.')');

            return redirect(route('loanPayments.index'));
        }
        DB::transaction(function()use ($input,$due,$request){
            $loan = Loan::find($request->loan_id);
            $input['landlord_id'] = $loan->landlord_id;
            $input['reference'] = 'PAYMENT';
            $input['transaction_type'] = debit;

            $loanPayment = $this->loanPaymentRepository->create($input);

            if($input['amount'] >= $due){
                $loan->status = true;
                $loan->save();
            }

        });

        Flash::success('Loan Payment saved successfully.');

        return redirect(route('loanPayments.index'));
    }

    /**
     * Display the specified LoanPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $loanPayment = $this->loanPaymentRepository->findWithoutFail($id);

        if (empty($loanPayment)) {
            Flash::error('Loan Payment not found');

            return redirect(route('loanPayments.index'));
        }

        return view('loan_payments.show')->with('loanPayment', $loanPayment);
    }

    /**
     * Show the form for editing the specified LoanPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $loanPayment = $this->loanPaymentRepository->findWithoutFail($id);

        if (empty($loanPayment)) {
            Flash::error('Loan Payment not found');

            return redirect(route('loanPayments.index'));
        }

        return view('loan_payments.edit')->with('loanPayment', $loanPayment);
    }

    /**
     * Update the specified LoanPayment in storage.
     *
     * @param  int              $id
     * @param UpdateLoanPaymentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoanPaymentRequest $request)
    {
        $loanPayment = $this->loanPaymentRepository->findWithoutFail($id);

        if (empty($loanPayment)) {
            Flash::error('Loan Payment not found');

            return redirect(route('loanPayments.index'));
        }

        $loanPayment = $this->loanPaymentRepository->update($request->all(), $id);

        Flash::success('Loan Payment updated successfully.');

        return redirect(route('loanPayments.index'));
    }

    /**
     * Remove the specified LoanPayment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $loanPayment = $this->loanPaymentRepository->findWithoutFail($id);

        if (empty($loanPayment)) {
            Flash::error('Loan Payment not found');

            return redirect(route('loanPayments.index'));
        }

        $this->loanPaymentRepository->delete($id);

        Flash::success('Loan Payment deleted successfully.');

        return redirect(route('loanPayments.index'));
    }
}
