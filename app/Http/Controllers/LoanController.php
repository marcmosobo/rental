<?php

namespace App\Http\Controllers;

use App\DataTables\LoanDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\InterestRate;
use App\Models\LandlordAccount;
use App\Models\Masterfile;
use App\Repositories\LoanRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

class LoanController extends AppBaseController
{
    /** @var  LoanRepository */
    private $loanRepository;

    public function __construct(LoanRepository $loanRepo)
    {
        $this->middleware('auth');
        $this->loanRepository = $loanRepo;
    }

    /**
     * Display a listing of the Loan.
     *
     * @param LoanDataTable $loanDataTable
     * @return Response
     */
    public function index(LoanDataTable $loanDataTable)
    {
        return $loanDataTable->render('loans.index',[
            'landlords' => Masterfile::where('b_role',landlord)->get(),
            'rates'=>InterestRate::all()
        ]);
    }

    /**
     * Show the form for creating a new Loan.
     *
     * @return Response
     */
    public function create()
    {
        return view('loans.create');
    }

    /**
     * Store a newly created Loan in storage.
     *
     * @param CreateLoanRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanRequest $request)
    {
        $input = $request->all();
        $input['created_by'] = Auth::user()->mf_id;
        DB::transaction(function()use ($input){
            $loan = $this->loanRepository->create($input);
            $acc = LandlordAccount::create([
                'loan_id' => $loan->id,
                'landlord_id' => $loan->landlord_id,
                'reference' => 'LOAN',
                'transaction_type'=> credit,
                'amount' => $loan->principle * (1+ $loan->rate/100),
                'date'=>$input['loan_date']
            ]);
        });


        Flash::success('Loan saved successfully.');

        return redirect(route('loans.index'));
    }

    /**
     * Display the specified Loan.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $loan = $this->loanRepository->findWithoutFail($id);

        if (empty($loan)) {
            Flash::error('Loan not found');

            return redirect(route('loans.index'));
        }

        return view('loans.show')->with('loan', $loan);
    }

    /**
     * Show the form for editing the specified Loan.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $loan = $this->loanRepository->findWithoutFail($id);

        if (empty($loan)) {
            Flash::error('Loan not found');

            return redirect(route('loans.index'));
        }

        return view('loans.edit')->with('loan', $loan);
    }

    /**
     * Update the specified Loan in storage.
     *
     * @param  int              $id
     * @param UpdateLoanRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoanRequest $request)
    {
        $loan = $this->loanRepository->findWithoutFail($id);

        if (empty($loan)) {
            Flash::error('Loan not found');

            return redirect(route('loans.index'));
        }

        $loan = $this->loanRepository->update($request->all(), $id);

        Flash::success('Loan updated successfully.');

        return redirect(route('loans.index'));
    }

    /**
     * Remove the specified Loan from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $loan = $this->loanRepository->findWithoutFail($id);

        if (empty($loan)) {
            Flash::error('Loan not found');

            return redirect(route('loans.index'));
        }

        $this->loanRepository->delete($id);
        LandlordAccount::where('loan_id',$id)->delete();

        Flash::success('Loan deleted successfully.');

        return redirect(route('loans.index'));
    }

    public function details($id){
        $details = LandlordAccount::where('loan_id',$id)->get();

        return response()->json($details);
    }
}
