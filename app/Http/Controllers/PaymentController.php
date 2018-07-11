<?php

namespace App\Http\Controllers;

use App\DataTables\PaymentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Jobs\SendSms;
use App\Models\CustomerAccount;
use App\Models\Lease;
use App\Models\Masterfile;
use App\Models\Payment;
use App\Models\PropertyUnit;
use App\Repositories\PaymentRepository;
use Carbon\Carbon;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use League\Csv\Statement;
use Response;

class PaymentController extends AppBaseController
{
    /** @var  PaymentRepository */
    private $paymentRepository;

    public function __construct(PaymentRepository $paymentRepo)
    {
        $this->middleware('auth');
        $this->paymentRepository = $paymentRepo;
    }

    /**
     * Display a listing of the Payment.
     *
     * @param PaymentDataTable $paymentDataTable
     * @return Response
     */
    public function index(PaymentDataTable $paymentDataTable)
    {
        return $paymentDataTable->render('payments.index',[
            'units'=>PropertyUnit::all()
        ]);
    }

    /**
     * Show the form for creating a new Payment.
     *
     * @return Response
     */
    public function create()
    {
        return view('payments.create');
    }

    /**
     * Store a newly created Payment in storage.
     *
     * @param CreatePaymentRequest $request
     *
     * @return Response
     */
    public function store(CreatePaymentRequest $request)
    {
        $input = $request->all();

        $payment = $this->paymentRepository->create($input);

        Flash::success('Payment saved successfully.');

        return redirect(route('payments.index'));
    }

    /**
     * Display the specified Payment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $payment = $this->paymentRepository->findWithoutFail($id);

        return response()->json($payment);
    }

    /**
     * Show the form for editing the specified Payment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $payment = $this->paymentRepository->findWithoutFail($id);

//        if (empty($payment)) {
//            Flash::error('Payment not found');
//
//            return redirect(route('payments.index'));
//        }

        return response()->json($payment);
    }

    /**
     * Update the specified Payment in storage.
     *
     * @param  int              $id
     * @param UpdatePaymentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePaymentRequest $request)
    {
        $payment = $this->paymentRepository->findWithoutFail($id);

        if (empty($payment)) {
            Flash::error('Payment not found');

            return redirect(route('payments.index'));
        }

        $input = $request->all();
        $input['updated_by'] = Auth::id();

        $payment = $this->paymentRepository->update($input, $id);

        Flash::success('Payment updated successfully.');

        return redirect(route('unprocessedPayments.index'));
    }

    /**
     * Remove the specified Payment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $payment = $this->paymentRepository->findWithoutFail($id);

        if (empty($payment)) {
            Flash::error('Payment not found');

            return redirect(route('payments.index'));
        }

        $this->paymentRepository->delete($id);

        Flash::success('Payment deleted successfully.');

        return redirect(route('payments.index'));
    }

    public function processPayment($id){
        $payment = Payment::find($id);
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

                     DB::transaction(function () use ($input, $tenant, $lease, $propertyUnit, $payment) {
                        $acc = CustomerAccount::create([
                            'tenant_id' => $tenant->id,
                            'lease_id' => $lease->id,
                            'unit_id' => $propertyUnit->id,
                            'payment_id' => $payment->id,
                            'ref_number' => $payment->ref_number,
                            'transaction_type' => debit,
                            'amount' => $payment->amount,
                            'date' => Carbon::today()
                        ]);

                        $payment->status = true;
                        $payment->house_number = $propertyUnit->unit_number;
                        $payment->tenant_id = $tenant->id;
                        $payment->client_id = $input['client_id'];
                        $payment->save();

                    });
                    //send sms
                    $message = 'Dear '.explode(' ',$tenant->full_name)[0].' your payment of '.$payment->amount.' was received. Kindly enter exactly '.$propertyUnit->unit_number.' as the account number the next time when paying rent.';

                    SendSms::dispatch($message,$payment->phone_number,$tenant);
                }else{
                    Flash::error('This house has no active lease');
                    return redirect(route('payments.index'));
                }
            }
        }else{
            Flash::error('You must choose house number.');
            return redirect(route('unprocessedPayments.index'));
        }
        Flash::success('Payment processed successfully.');
        return redirect(route('unprocessedPayments.index'));
    }

//    public function reversePayment(Request $request, $id){
//        $payment = Payment::find($id);
//        $reversal = Payment::create([
//            'payment_mode'=>$payment->payment_mode,
//            'house_number'=>$payment->house_number,
//            'tenant_id'=>$payment->tenant,
//            'ref_number'=>
//        ]);
//    }


    public function crossCheck(){
        return view('payments.uploads');
    }

    public function crossCheckPayments(Request $request){

//        var_dump($request->file('import_file')->path());die;
        $stream = fopen($request->file('import_file')->path(), 'r');
        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(',');
        $csv->setHeaderOffset(5);

        $stmt = (new Statement())
            ->offset(5);
//            ->limit(25);

        //query your records from the document
        $records = $stmt->process($csv);
//        echo count($records);die;

        $recs =[];
        foreach ($records as $record){
            $payments = Payment::where('ref_number',$record['Receipt No.'])->first();
            if(is_null($payments)){
                if(!empty($record['Paid In'])){
                    $record['Paid In'] = floatval($record['Paid In']);
                    $recs[] = $record;
                }
            }
//            echo $record['Receipt No.'];
        }
//        print_r($recs);die;
        return view('payments.uploads',[
            'payments'=>collect($recs)
        ]);
    }
}
