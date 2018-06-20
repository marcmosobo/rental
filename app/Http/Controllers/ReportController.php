<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\CustomerAccount;
use App\Models\Lease;
use App\Models\Masterfile;
use App\Models\Payment;
use App\Models\PolicyDetail;
use App\Models\Property;
use App\Models\PropertyUnit;
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

    public function getPropertyStatement(Request $request){
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
                    $arrears = CustomerAccount::where([['created_at','<',Carbon::parse($request->date_from)],['tenant_id',$lease->tenant_id]])->get();
                    $aBF = $arrears->where('transaction_type',credit)->sum('amount') - $arrears->where('transaction_type',debit)->sum('amount');

                   //total due
                    $totalDue= CustomerAccount::query()
                        ->where('tenant_id',$lease->tenant_id)
                        ->where('transaction_type',credit)
                        ->whereBetween('created_at',[Carbon::parse($request->date_from),Carbon::parse($request->date_to)->endOfDay()])
                        ->sum('amount') + $aBF;

                    //amount paid
                    $amountPaid = $arrears = CustomerAccount::query()
                            ->where('tenant_id',$lease->tenant_id)
                            ->where('transaction_type',debit)
                            ->whereBetween('created_at',[Carbon::parse($request->date_from),Carbon::parse($request->date_to)->endOfDay()])
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
            'landlord'=>Masterfile::find($property->landlord_id)->full_name,
        ]);
    }

    public function getTenantStatement(Request $request){
        $statement = CustomerAccount::query()
            ->where('tenant_id',$request->tenant)

            ->get();
        print_r($statement->toArray());die;
        return view('reports.tenant-statement',[
            'tenants'=>Masterfile::where('b_role',\tenant)->get()
        ]);
    }
}
