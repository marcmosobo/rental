<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\CustomerAccount;
use App\Models\LandlordRemittance;
use App\Models\Lease;
use App\Models\Masterfile;
use App\Models\Payment;
use App\Models\Property;
use App\Models\PropertyExpenditure;
use App\Models\PropertyUnit;
use App\Models\ServiceOption;
use App\Models\Tenant;
use App\Models\UnitServiceBill;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function tenantStatement(){

        return view('reports.tenant-statement',[
            'tenants'=>Masterfile::where('b_role',\tenant)->get()
        ]);
    }

    public function propertyStatement(){
        return view('reports.property-statement',[
            'properties'=>Property::all()
        ]);
    }

    public function getPropertyStatement2(Request $request){
        if(!$request->isMethod('POST')){
            return redirect('propertyStatement');
        }
        $input = $request->all();
        $propertyUnits = PropertyUnit::query()
            ->select(['property_units.*'])
            ->where('property_id',$request->property_id)
            ->get();
        $reports =[];
        if(count($propertyUnits)){
            foreach ($propertyUnits as $propertyUnit){
                $lease = Lease::where([
                    ['unit_id',$propertyUnit->id],['status',true]
                ])->first();
                if(!empty($lease)){
                    $arrears = CustomerAccount::where([['date','<',Carbon::parse($request->date_from)],['tenant_id',$lease->tenant_id]])->get();
                    $aBF = $arrears->where('transaction_type',credit)->sum('amount') - $arrears->where('transaction_type',debit)->sum('amount');

                   //total due
                    $totalDue= CustomerAccount::query()
                        ->where('unit_id',$lease->unit_id)
                        ->where('transaction_type',credit)
                        ->whereBetween('date',[Carbon::parse($request->date_from),Carbon::parse($request->date_to)->endOfDay()])
                        ->sum('amount') + $aBF;

                    //amount paid
                    $amountPaid = $arrears = CustomerAccount::query()
                            ->where('unit_id',$lease->unit_id)
                            ->where('transaction_type',debit)
                            ->whereBetween('date',[Carbon::parse($request->date_from),Carbon::parse($request->date_to)->endOfDay()])
                            ->sum('amount');

                    $report=[
                        'unit_number'=>$propertyUnit->unit_number,
                        'tenant'=>Masterfile::find($lease->tenant_id)->full_name,
                        'status'=>'Occupied',
                        'monthly_rent'=> UnitServiceBill::where([['unit_id',$propertyUnit->id],['period',monthly]])->sum('amount'),
                        'arrears_bf'=>$aBF,
                        'total_due'=>$totalDue,
                        'amt_paid'=>$amountPaid,
                        'arrears_cf'=>$totalDue-$amountPaid
                    ];
                }else{
                    $report=[
                        'unit_number'=>$propertyUnit->unit_number,
                        'tenant'=>'N/A',
                        'status'=>'Vacant',
                        'monthly_rent'=> 0,
                        'arrears_bf'=>0,
                        'total_due'=>0,
                        'amt_paid'=>0,
                        'arrears_cf'=>0
                    ];
                }
                $reports[]=$report;
            }
        }

            $reports = collect($reports);
        $property = Property::find($request->property_id);
        return view('reports.property-statement',[
            'properties'=>Property::all(),
            'pStatements'=> $reports,
            'from'=>Carbon::parse($request->date_from)->toFormattedDateString(),
            'to'=>Carbon::parse($request->date_to)->toFormattedDateString(),
            'prop'=>$property->name,
            'landlord'=>Masterfile::find($property->landlord_id),
            'commission'=>$property->commission
        ]);
    }

    public function getTenantStatement(Request $request){

        if(!$request->isMethod('POST')){
            return redirect('tenantStatement');
        }
        $statements = CustomerAccount::query()
            ->where('tenant_id',$request->tenant)
            ->orderBy('id')
            ->get();
//        print_r($statement->toArray());die;
        $tenantStatements =[];
        if(count($statements)){
            foreach ($statements as $statement){
                if(is_null($statement->bill_id)){
                    $trans =[
                        'date'=>$statement->date,
                        'house_number'=>PropertyUnit::find($statement->unit_id)->unit_number,
                        'bill_type'=>'Payment',
                        'debit'=>$statement->amount,
                        'ref_number'=>$statement->ref_number,
                        'credit'=> 0
                    ];
                    $tenantStatements[]= $trans;
                }else{
                    $billDetails = BillDetail::where('bill_id',$statement->bill_id)->get();
                    $bill = Bill::query()
                        ->select("property_units.unit_number as house_number")
                        ->leftJoin('leases','leases.id','=','bills.lease_id')
                        ->leftJoin('property_units','property_units.id','=','leases.unit_id')
                        ->where('bills.id',$statement->bill_id)->first();
                    if(count($billDetails)){
                        foreach ($billDetails as $billDetail){
                            if($billDetail->amount < 0){
                                $trans =[
                                    'date'=>$billDetail->bill_date,
                                    'house_number'=>$bill->house_number,
                                    'bill_type'=>'Bill',
                                    'ref_number'=>"Lease Reversal",
                                    'debit'=> -$billDetail->amount,
                                    'credit'=>0,
                                ];
                            }else{
                                $trans =[
                                    'date'=>$billDetail->bill_date,
                                    'house_number'=>$bill->house_number,
                                    'bill_type'=>'Bill',
                                    'ref_number'=>ServiceOption::find($billDetail->service_bill_id)->name,
                                    'debit'=> 0,
                                    'credit'=>$billDetail->amount,
                                ];
                            }

                            $tenantStatements[]= $trans;
                        }
                    }
                }

            }
        }
        return view('reports.tenant-statement',[
            'tenants'=>Masterfile::where('b_role',\tenant)->get(),
            'statements'=>collect($tenantStatements),
            'tenant_name'=>Masterfile::find($request->tenant)->full_name
        ]);
    }

    public function getPropertyStatement(Request $request){
        if(!$request->isMethod('POST')){
            return redirect('propertyStatement');
        }
        $input = $request->all();
        $propertyUnits = PropertyUnit::query()
            ->select(['property_units.*'])
            ->where('property_id',$request->property_id)
            ->get();
        $reports =[];
        if(count($propertyUnits)){
            foreach ($propertyUnits as $propertyUnit){
                $lease = Lease::where([
                    ['unit_id',$propertyUnit->id],['status',true]
                ])->first();
                if(!empty($lease)){
                    $arrears = CustomerAccount::where([['date','<',Carbon::parse($request->date_from)],['tenant_id',$lease->tenant_id]])->get();
                    $aBF = $arrears->where('transaction_type',credit)->sum('amount') - $arrears->where('transaction_type',debit)->sum('amount');

                    //total due
                    $totalDue= CustomerAccount::query()
                            ->where('unit_id',$lease->unit_id)
                            ->where('transaction_type',credit)
                            ->whereBetween('date',[Carbon::parse($request->date_from),Carbon::parse($request->date_to)->endOfDay()])
                            ->sum('amount') + $aBF;

                    //amount paid
                    $amountPaid = $arrears = CustomerAccount::query()
                        ->where('unit_id',$lease->unit_id)
                        ->where('transaction_type',debit)
                        ->whereBetween('date',[Carbon::parse($request->date_from),Carbon::parse($request->date_to)->endOfDay()])
                        ->sum('amount');

                    $report=[
                        'unit_number'=>$propertyUnit->unit_number,
                        'tenant'=>Masterfile::find($lease->tenant_id)->full_name,
                        'status'=>'Occupied',
                        'monthly_rent'=> UnitServiceBill::where([['unit_id',$propertyUnit->id],['period',monthly]])->sum('amount'),
                        'arrears_bf'=>$aBF,
                        'total_due'=>$totalDue,
                        'amt_paid'=>$amountPaid,
                        'arrears_cf'=>$totalDue-$amountPaid
                    ];
                }else{
                    $report=[
                        'unit_number'=>$propertyUnit->unit_number,
                        'tenant'=>'N/A',
                        'status'=>'Vacant',
                        'monthly_rent'=> 0,
                        'arrears_bf'=>0,
                        'total_due'=>0,
                        'amt_paid'=>0,
                        'arrears_cf'=>0
                    ];
                }
                $reports[]=$report;
            }
        }

        $reports = collect($reports);
        $property = Property::find($request->property_id);
        return view('reports.property-statement',[
            'properties'=>Property::all(),
            'pStatements'=> $reports,
            'from'=>Carbon::parse($request->date_from)->toFormattedDateString(),
            'to'=>Carbon::parse($request->date_to)->toFormattedDateString(),
            'prop'=>$property->name,
            'landlord'=>Masterfile::find($property->landlord_id),
            'commission'=>$property->commission
        ]);
    }

    public function tenantArrears(){
        return view('reports.tenant-arrears',[
            'properties'=>Property::all()
        ]);
    }

    public function getTenantArrears(Request $request){
        if(!$request->isMethod('POST')){
            return redirect('tenantArrears');
        }
        $from = Carbon::parse($request->date_from)->startOfDay();
        $to = Carbon::parse($request->date_to)->endOfDay();
        if($request->property_id == 'All'){
            $leases = Lease::where('status',true)->orderBy('property_id')->with(['unit','property','masterfile'])->get();
        }else{
            $leases = Lease::where('status',true)->where('property_id',$request->property_id)->orderBy('property_id')->with(['unit','property','masterfile'])->get();
        }
        $reports =[];
        if(count($leases)){
            foreach ($leases as $lease){
                $customerAccounts = CustomerAccount::where('lease_id',$lease->id)->get();

                //balance brought forward
                 $bf = $customerAccounts->where('date','<',$from)->where('transaction_type',credit)->sum('amount') - $customerAccounts->where('date','<',$from)->where('transaction_type',debit)->sum('amount');

                 //current
                $current = CustomerAccount::where('lease_id',$lease->id)
                       ->whereBetween('date',[$from,$to])->get();

                //current balance
                $currentBal = $current->where('transaction_type',credit)->sum('amount');

                $total = $currentBal +$bf;

                $paid = $current->where('transaction_type',debit)->sum('amount');
//                if($bf <0){
//                    $paid = $paid -$bf;
//                }

                 $cf = $total -$paid ;
                 if($cf >0){
                     $reports[]=[
                         'property_name'=>(!is_null($lease->property)) ? $lease->property->name: '',
                         'house_number'=>$lease->unit->unit_number,
                         'tenant'=>$lease->masterfile->full_name,
                         'phone_number'=>$lease->masterfile->phone_number,
                         'bbf'=>$bf,
                         'current'=>$currentBal,
                         'total'=>($bf <0)? -$bf + $total: $total,
                         'paid'=>($bf <0)? -$bf + $paid: $paid,
                         'bcf'=>$cf
                     ];
                 }

            }
        }
//        print_r($reports);
        return view('reports.tenant-arrears',[
            'arrears'=>collect($reports),
            'from'=>$from,
            'to'=>$to,
            'properties'=>Property::all()
        ]);
    }

    public function plotStatement(){
        return view('reports.plot-statement',[
            'properties'=>Property::all()
        ]);
    }

    public function getPlotStatement(Request $request){
        if(!$request->isMethod('POST')){
            return redirect('plotStatement');
        }
        $from = $request->date_from;
        $to = $request->date_to;

        $plotUnits = PropertyUnit::where('property_id',$request->property_id)->get();
        $property = Property::find($request->property_id);
        $reports =[];
        if(count($plotUnits)){
            foreach ($plotUnits as $unit){
                $lease = Lease::where('unit_id',$unit->id)
                    ->where('status',true)
                    ->with(['unit','property','masterfile'])
                    ->first();
                if(!is_null($lease)){
                    $customerAccounts = CustomerAccount::where('lease_id',$lease->id)->get();

                    //balance brought forward
                    $bf = $customerAccounts->where('date','<',$from)->where('transaction_type',credit)->sum('amount') - $customerAccounts->where('date','<',$from)->where('transaction_type',debit)->sum('amount');

                    //current
                    $current = CustomerAccount::where('lease_id',$lease->id)
                        ->whereBetween('date',[$from,$to])->get();

                    //current balance
                    $currentBal = $current->where('transaction_type',credit)->sum('amount');

                    $total = $currentBal +$bf;

                    $paid = $current->where('transaction_type',debit)->sum('amount');
//                if($bf <0){
//                    $paid = $paid -$bf;
//                }
                    $monthlyRent =

                    $cf = $total -$paid ;
//                    if($cf >0){
                        $reports[]=[
                            'house_number'=>$lease->unit->unit_number,
                            'tenant'=>$lease->masterfile->full_name,
                            'phone_number'=>$lease->masterfile->phone_number,
                            'bbf'=>$bf,
                            'status'=>"OCCUPIED",
                            'monthly_rent'=> UnitServiceBill::where([['unit_id',$unit->id],['period',monthly]])->sum('amount'),
                            'current'=>$currentBal,
                            'total'=>($bf <0)? -$bf + $total: $total,
                            'paid'=>($bf <0)? - $bf + $paid: $paid,
                            'bcf'=>($cf <0)? 0: $cf,
                            'over_payment'=>($cf <0)? -$cf: 0,
                        ];
//                    }
                }else{
                    $reports[]=[
                        'house_number'=>$unit->unit_number,
                        'tenant'=>'-',
                        'phone_number'=>'-',
                        'bbf'=>0,
                        'status'=>"VACANT",
                        'monthly_rent'=> 0,
                        'current'=>0,
                        'total'=>0,
                        'paid'=>0,
                        'bcf'=>0,
                        'over_payment'=> 0,
                    ];
                }
            }
        }
//        print_r($reports);die;
        return view('reports.plot-statement',[
            'reports'=>collect($reports),
            'from'=>$from,
            'to'=>$to,
            'properties'=>Property::all(),
//            'landlord' =>$property->masterfile,
            'prop'=>$property->name
        ]);
    }

    public function landlordSettlementStatement(){
        return view('reports.landlord-settlement',[
            'properties'=>Property::all()
        ]);
    }

    public function getLandlordStatement(Request $request){
        if(!$request->isMethod('POST')){
            return redirect('landlordSettlementStatement');
        }
        $from = $request->date_from;
        $to = $request->date_to;

        $plotUnits = PropertyUnit::where('property_id',$request->property_id)->get();
        $property = Property::find($request->property_id);
        $reports =[];
        if(count($plotUnits)){
            foreach ($plotUnits as $unit){
                $lease = Lease::where('unit_id',$unit->id)
                    ->where('status',true)
                    ->with(['unit','property','masterfile'])
                    ->first();
                if(!is_null($lease)){
                    $customerAccounts = CustomerAccount::where('lease_id',$lease->id)->get();

                    //balance brought forward
                    $bf = $customerAccounts->where('date','<',$from)->where('transaction_type',credit)->sum('amount') - $customerAccounts->where('date','<',$from)->where('transaction_type',debit)->sum('amount');

                    //current
                    $current = CustomerAccount::where('lease_id',$lease->id)
                        ->whereBetween('date',[$from,$to])->get();

                    //current balance
                    $currentBal = $current->where('transaction_type',credit)->sum('amount');

                    $total = $currentBal +$bf;

                    $paid = $current->where('transaction_type',debit)->sum('amount');
//                if($bf <0){
//                    $paid = $paid -$bf;
//                }
                    $monthlyRent =

                    $cf = $total -$paid ;
//                    if($cf >0){

                    $rent = UnitServiceBill::query()
                        ->select('unit_service_bills.amount')
                        ->leftJoin('service_options','service_options.id','=','unit_service_bills.service_bill_id')
                        ->where([['unit_id',$unit->id],['period',monthly]])
                        ->where('service_options.code',rent)->first()
                    ;
//                    var_dump($rent);die;
                    $amPaid = (($bf <0)? - $bf + $paid: $paid );
                    $reports[]=[
                        'house_number'=>$lease->unit->unit_number,
                        'tenant'=>$lease->masterfile->full_name,
                        'phone_number'=>$lease->masterfile->phone_number,
                        'bbf'=>$bf,
                        'status'=>"OCCUPIED",
                        'monthly_rent'=> $rent->amount,
                        'current'=>$currentBal,
                        'total'=>($bf <0)? -$bf + $total: $total,
//                        'paid'=>((($bf <0)? - $bf + $paid: $paid ) >)?,
                        'paid'=>($amPaid),
                        'rentPaid'=>$rentPaid =($amPaid > $rent->amount)? $rent->amount: $amPaid,
                        'otherBills'=>($cf <0)? 0: $cf,
//                        'bcf'=>($cf <0)? 0: $cf,
                        'bcf'=>$rent->amount - $rentPaid,
                        'over_payment'=>($cf <0)? -$cf: 0,
                    ];
//                    }
                }else{
                    $reports[]=[
                        'house_number'=>$unit->unit_number,
                        'tenant'=>'-',
                        'phone_number'=>'-',
                        'bbf'=>0,
                        'status'=>"VACANT",
                        'monthly_rent'=> 0,
                        'current'=>0,
                        'total'=>0,
                        'paid'=>0,
                        'bcf'=>0,
                        'over_payment'=> 0,
                    ];
                }
            }
        }

        $expenditures = PropertyExpenditure::where('property_id',$request->property_id)->with(['expenditure'])->get();

//        print_r($expenditures->toArray());die;
        return view('reports.landlord-settlement',[
            'reports'=>collect($reports),
            'from'=>$from,
            'to'=>$to,
            'properties'=>Property::all(),
//            'landlord' =>$property->masterfile,
            'prop'=>$property->name,
            'expenditures'=>$expenditures,
            'commission'=> $property->commission
        ]);
    }

    public function landlordPSettlements(){
        return view('reports.landlord-properties-settlement',[
            'landlords'=>Masterfile::where('b_role',landlord)->get()
        ]);
    }

    public function getLandlordPSettlements(Request $request){
        if(!$request->isMethod('POST')){
            return redirect('landlordPSettlements');
        }
        $from = $request->date_from;
        $to = $request->date_to;
//        echo $request->landlord_id;die;
        $plotUnits = PropertyUnit::query()
            ->select(['property_units.*'])
            ->leftJoin('properties','properties.id','=','property_units.property_id')
            ->where('properties.landlord_id',$request->landlord_id)->get();
//        print_r($plotUnits->toArray());die;
//        $property = Property::find($request->property_id);
        $reports =[];
        $expenses = [];
        if(count($plotUnits)){
            foreach ($plotUnits as $unit){
                $lease = Lease::where('unit_id',$unit->id)
                    ->where('status',true)
                    ->with(['unit','property','masterfile'])
                    ->first();
                if(!is_null($lease)){
                    $customerAccounts = CustomerAccount::where('lease_id',$lease->id)->get();

                    //balance brought forward
                    $bf = $customerAccounts->where('date','<',$from)->where('transaction_type',credit)->sum('amount') - $customerAccounts->where('date','<',$from)->where('transaction_type',debit)->sum('amount');

                    //current
                    $current = CustomerAccount::where('lease_id',$lease->id)
                        ->whereBetween('date',[$from,$to])->get();

                    //current balance
                    $currentBal = $current->where('transaction_type',credit)->sum('amount');

                    $total = $currentBal +$bf;

                    $paid = $current->where('transaction_type',debit)->sum('amount');
//                if($bf <0){
//                    $paid = $paid -$bf;
//                }
                    $monthlyRent =

                    $cf = $total -$paid ;
//                    if($cf >0){

                    $rent = UnitServiceBill::query()
                        ->select('unit_service_bills.amount')
                        ->leftJoin('service_options','service_options.id','=','unit_service_bills.service_bill_id')
                        ->where([['unit_id',$unit->id],['period',monthly]])
                        ->where('service_options.code',rent)->first()
                    ;
//                    var_dump($rent);die;
                    $amPaid = (($bf <0)? - $bf + $paid: $paid );
                    $reports[]=[
                        'property_name'=>(!is_null($lease->property))?$lease->property->name: '',
                        'house_number'=>$lease->unit->unit_number,
                        'tenant'=>$lease->masterfile->full_name,
                        'phone_number'=>$lease->masterfile->phone_number,
                        'bbf'=>$bf,
                        'status'=>"OCCUPIED",
                        'monthly_rent'=> $rent->amount,
                        'current'=>$currentBal,
                        'total'=>($bf <0)? -$bf + $total: $total,
//                        'paid'=>((($bf <0)? - $bf + $paid: $paid ) >)?,
                        'paid'=>($amPaid),
                        'rentPaid'=>$rentPaid =($amPaid > $rent->amount)? $rent->amount: $amPaid,
                        'otherBills'=>($cf <0)? 0: $cf,
//                        'bcf'=>($cf <0)? 0: $cf,
                        'bcf'=>$rent->amount - $rentPaid,
                        'over_payment'=>($cf <0)? -$cf: 0,
                    ];
//                    }
                }else{
                    $reports[]=[
                        'house_number'=>$unit->unit_number,
                        'property_name'=>Property::find($unit->property_id)->name,
                        'tenant'=>'-',
                        'phone_number'=>'-',
                        'bbf'=>0,
                        'status'=>"VACANT",
                        'monthly_rent'=> 0,
                        'current'=>0,
                        'total'=>0,
                        'paid'=>0,
                        'bcf'=>0,
                        'over_payment'=> 0,
                        'rentPaid'=>0
                    ];
                }
            }
        }

        $expenditures = PropertyExpenditure::where('landlord_id',$request->landlord_id)
            ->whereBetween('date',[$from,$to])
            ->sum('amount');

//        print_r($expenditures->toArray());die;
        return view('reports.landlord-properties-settlement',[
            'reports'=>collect($reports),
            'from'=>$from,
            'to'=>$to,
            'landlords'=>Masterfile::where('b_role',landlord)->get(),
//            'landlord' =>$property->masterfile,
//            'prop'=>$property->name,
            'expenditures'=>$expenditures,
            'withdrawn'=> LandlordRemittance::where('landlord_id',$request->landlord_id)->whereBetween('date',[$from,$to])->sum('amount')

        ]);
    }

    public function rentPayments(Request $request)
    {

        return view('reports.property-statement3',[
            'properties'=>Property::all()
        ]);

    }
    public function getrentPayments(Request $request)
    {
        if(!$request->isMethod('POST')){
            return redirect('rentpay');
        }
        $input=$request->all();
        $payed=CustomerAccount::query()
            ->where('transaction_type',debit)
            ->whereBetween('date',[Carbon::parse($request->date_from),Carbon::parse($request->date_to)->endOfDay()])->get();
        $pay=CustomerAccount::query()
            ->leftJoin('masterfiles', 'customer_accounts.tenant_id', '=', 'masterfiles.id')
            ->leftJoin ('property_units','customer_accounts.unit_id','=','property_units.id')
            ->leftJoin('properties','property_units.property_id','=','properties.id')
            ->whereBetween('date',[Carbon::parse($request->date_from),Carbon::parse($request->date_to)->endOfDay()])
            ->where('transaction_type', '=', debit)
//            ->sum(number_format($pay->amount))
            ->orderBy('date')
            ->get();

//            $total=CustomerAccount::query()
//                ->sum('amount')
//                 ->whereBetween('date',[Carbon::parse($request->date_from),Carbon::parse($request->date_to)->endOfDay()])->get();
//
//            dd($total);

//        print_r($pay->toArray());die;
        return view('reports.property-statement3',[
            'pay'=>$pay
        ]);



    }

    public function mpesaPayments(){

        return view('reports.daily-payments',[
            'properties'=>Property::all()
        ]);

    }

    public function getDailyPaymentsByDate(Request $request)
    {
        if(!$request->isMethod('POST')){
            return redirect('dailyPayments');
        }
        $input = $request->all();
        echo $date_from = Carbon::parse($request->date_from)->startOfDay();
        echo $date_to = Carbon::parse($request->date_to)->endOfDay();
//       echo  $date_to = Carbon::parse('11-07-2018 09:35:53');

        $payments = [];
        if($request->filter_by == 'all'){
            $payments = Payment::query()
                ->whereBetween('received_on',[$date_from,$date_to])
                ->with(['masterfile'])
                ->get();
        }else if($request->filter_by == 'mpesa'){
            $payments = Payment::query()
                ->where('payment_mode',mpesa)
                    ->whereBetween('received_on',[$date_from,$date_to])
                ->with(['masterfile'])
                ->get();
        }else if($request->filter_by == 'bank'){
            $payments = Payment::query()
                ->where('payment_mode','Bank')
                ->whereBetween('received_on',[$date_from,$date_to])
                ->with(['masterfile'])
                ->get();
        }else if($request->filter_by == 'processed'){
            $payments = Payment::query()
                ->where('status',true)
                ->whereBetween('received_on',[$date_from,$date_to])
                ->with(['masterfile'])
                ->get();
        }else{
            $payments = Payment::query()
                ->where('status',false)
                ->whereBetween('received_on',[$date_from,$date_to])
                ->with(['masterfile'])
                ->get();
        }
//        print_r($payments->toArray());die;

        return view('reports.daily-payments',[
            'payments'=>collect($payments)
        ]);
    }

    public function bankStatement()
    {

        return view('reports.bank-statement',[

            'banks'=>Bank::all()
        ]);
    }

    public function getBankStatement(Request $request)
    {
        if (!$request->isMethod('POST')) {
            return redirect('bankStatement');
        }

        $input = $request->all();
//        dd($input);

        if($request->bank =='all'){

            $bankStatement = Payment::query()
                ->where('bank_id','<>',null)
                ->with(['bank','masterfile','unit.property'])
                ->whereBetween('received_on',[Carbon::parse($request->date_from),Carbon::parse($request->date_to)->endOfDay()])
                ->get();
        }else{
            $bankStatement = Payment::query()
                ->where('bank_id','<>',null)
                ->where('bank_id',$request->bank)
                ->whereBetween('received_on',[Carbon::parse($request->date_from),Carbon::parse($request->date_to)->endOfDay()])
                ->with(['bank','masterfile','unit.property'])
                ->get();
        }
        return view('reports.bank-statement',[
            'payments'=>$bankStatement,
            'banks'=>Bank::all(),
            'bank_name' => Bank::find($request->bank),
            'input'=>$request->all()
        ]);
    }
}
