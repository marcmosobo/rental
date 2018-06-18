<?php

namespace App\Http\Controllers;

use App\DataTables\PayBillDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePayBillRequest;
use App\Http\Requests\UpdatePayBillRequest;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\CustomerAccount;
use App\Models\Lease;
use App\Models\Masterfile;
use App\Models\Payment;
use App\Models\Tenant;
use App\Repositories\PayBillRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

class PayBillController extends AppBaseController
{
    /** @var  PayBillRepository */
    private $payBillRepository;

    public function __construct(PayBillRepository $payBillRepo)
    {
        $this->middleware('auth');
        $this->payBillRepository = $payBillRepo;
    }

    /**
     * Display a listing of the PayBill.
     *
     * @param PayBillDataTable $payBillDataTable
     * @return Response
     */
    public function index(PayBillDataTable $payBillDataTable)
    {
        return $payBillDataTable->render('pay_bills.index',[
            'tenants'=>Tenant::where('b_role',\tenant)->get()
        ]);
    }

    /**
     * Show the form for creating a new PayBill.
     *
     * @return Response
     */
    public function create()
    {
        return view('pay_bills.create');
    }

    /**
     * Store a newly created PayBill in storage.
     *
     * @param CreatePayBillRequest $request
     *
     * @return Response
     */
    public function store(CreatePayBillRequest $request)
    {
        $input = $request->all();
        $this->validate($request,[
            'ref_number'=>'required',
            'amount'=> 'required',
            'tenant_id'=>'required'
        ]);

        $mf = Masterfile::find($input['tenant_id']);
//        print_r($input);die;
        $payment = DB::transaction(function()use($input,$mf){
            $lease = Lease::where('tenant_id',$input['tenant_id'])->first();

            $input['phone_number'] = $mf->phone_number;
            $input['house_number'] = $lease->unit_id;
            $input['BillRefNumber'] = $input['ref_number'];
            $input['client_id'] = Auth::user()->client_id;
            $input['created_by'] = Auth::user()->mf_id;
            $input['status']= true;
            $payBill = $this->payBillRepository->create($input);

            //reqister in customer account

            $customerAcc = CustomerAccount::create([
                'tenant_id'=>$input['tenant_id'],
                'lease_id'=> $lease->id,
                'unit_id'=>$lease->unit_id,
                'patment_id'=>$payBill->id,
                'ref_number'=>$input['ref_number'],
                'transaction_type'=>debit,
                'amount'=>$input['amount'],
            ]);

            $billDetails = BillDetail::query()
                ->select(['bill_details.*'])
                ->leftJoin('bills','bills.id','=','bill_details.bill_id')
                ->where('bills.tenant_id',$input['tenant_id'])
                ->where('bill_details.balance','>',0)
                ->where('bill_details.status',false)
                ->orderBy('bill_details.id')
                ->get();
//            print_r($billDetails->toArray());die;
            if(count($billDetails)){
                $amount = $input['amount'];
//                var_dump($amount);die;
                foreach ($billDetails as $billDetail){
                    if($amount > $billDetail->balance){
//                        echo 'first';die;
                        $amount = $amount - $billDetail->balance;
                        $billDetail->balance = 0;
                        $billDetail->status = true;
                        $billDetail->save();
                    }elseif($amount == $billDetail->balance){
                        $billDetail->balance = $billDetail->balance - $amount;
                        $billDetail->status= true;
                        $billDetail->save();
                        $amount = $billDetail->balance - $amount;
//                        echo 'second';die;
                    }else{
                        if($amount > 0){
                            $billDetail->balance = $billDetail->balance - $amount;
//                            echo $billDetail->balance;die;
                            $billDetail->save();
                            $amount = 0;
                        }
                    }
                }
            }
                return $payBill;
        });



        Flash::success('Bill paid successfully.');

        return redirect('receipt/'.$payment->id);
    }

    public function receipt(PayBillDataTable $payBillDataTable,$id)
    {
        $payment = Payment::find($id);
//        print_r($payment->toArray());die;
        return $payBillDataTable->render('pay_bills.index',[
            'tenants'=>Tenant::where('b_role',\tenant)->get(),
            'payment' =>$payment
        ]);
    }

    /**
     * Display the specified PayBill.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $payBill = $this->payBillRepository->findWithoutFail($id);

        if (empty($payBill)) {
            Flash::error('Pay Bill not found');

            return redirect(route('payBills.index'));
        }

        return view('pay_bills.show')->with('payBill', $payBill);
    }

    /**
     * Show the form for editing the specified PayBill.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $payBill = $this->payBillRepository->findWithoutFail($id);

        if (empty($payBill)) {
            Flash::error('Pay Bill not found');

            return redirect(route('payBills.index'));
        }

        return view('pay_bills.edit')->with('payBill', $payBill);
    }

    /**
     * Update the specified PayBill in storage.
     *
     * @param  int              $id
     * @param UpdatePayBillRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePayBillRequest $request)
    {
        $payBill = $this->payBillRepository->findWithoutFail($id);

        if (empty($payBill)) {
            Flash::error('Pay Bill not found');

            return redirect(route('payBills.index'));
        }

        $payBill = $this->payBillRepository->update($request->all(), $id);

        Flash::success('Pay Bill updated successfully.');

        return redirect(route('payBills.index'));
    }

    /**
     * Remove the specified PayBill from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $payBill = $this->payBillRepository->findWithoutFail($id);

        if (empty($payBill)) {
            Flash::error('Pay Bill not found');

            return redirect(route('payBills.index'));
        }

        $this->payBillRepository->delete($id);

        Flash::success('Pay Bill deleted successfully.');

        return redirect(route('payBills.index'));
    }

    public function searchBills(Request $request){
//        print_r($request->all());
        if($request->filter == "tenant"){
            $this->validate($request,[
                'tenant'=>'required'
            ]);

            $bills = BillDetail::query()
                ->leftJoin('bills','bills.id','=','bill_details.bill_id')
                ->leftJoin('service_options','service_options.id','=','bill_details.service_bill_id')
                ->leftJoin('leases','leases.id','=','bills.lease_id')
                ->leftJoin('property_units','property_units.id','=','leases.unit_id')
                ->where([
                    ['bills.tenant_id',$request->tenant],
                    ['bill_details.balance','>',0]
                ])->get();
//            echo 'here';

//            print_r($bills);
        }else{
            $this->validate($request,[
                'house_number'=>'required'
            ]);

            $bills = BillDetail::query()
                ->select(['bill_details.*'])
                ->leftJoin('bills','bills.id','=','bill_details.bill_id')
                ->leftJoin('service_options','service_options.id','=','bill_details.service_bill_id')
                ->leftJoin('leases','leases.id','=','bills.lease_id')
                ->leftJoin('property_units','property_units.id','=','leases.unit_id')
                ->where([
                    ['leases.unit_id',$request->house_number],
                    ['bill_details.balance','>',0]
                ])->get();
        }

        return view('pay_bills.index',[
            'tenants'=>Tenant::where('b_role',\tenant)->get(),
            'bills'=>$bills,
            'tenant_id' => $request->tenant
        ]);
    }
}
