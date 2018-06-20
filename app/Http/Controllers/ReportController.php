<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Lease;
use App\Models\Masterfile;
use App\Models\Payment;
use App\Models\PolicyDetail;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\Tenant;
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
                    $report=[
                        'unit_number'=>$propertyUnit->unit_number
                    ];
                }else{
                    $report=[
                        'unit_number'=>$propertyUnit->unit_number,
                        'tenant'=>'N/A',
                        'status'=>'Vacant',
                        'monthly_rent'=> '0.00',
                        'arrears_bf'=>'0.00',
                        'total_due'=>'0.00',
                        'amt_paid'=>'0.00'
                    ];
                }
                $reports[]=$report;
            }
        }

            print_r($reports);

//        return response()->json($propertyUnits);
    }
}
