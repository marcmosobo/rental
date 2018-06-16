<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Payment;
use App\Models\PolicyDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function policies(){

        return view('reports.policies');
    }

    public function getPoliciesReport(Request $request){
        $date_from = Carbon::parse($request->date_from)->startOfDay();
        $date_to = Carbon::parse($request->date_to)->endOfDay();
//        var_dump($date_from);
        $policies = PolicyDetail::query()
            ->select([
                'policy_details.*',
                'policies.policy_number',
                'policy_types.name as policy_type',
                'vehicles.registration_number',
                'insurance_service_providers.name'

            ])
            ->leftjoin('policies','policies.id','=','policy_details.policy_id')
            ->leftjoin('policy_types','policy_types.id','=','policy_details.policy_type')
            ->leftjoin('vehicles','vehicles.id','=','policies.vehicle_id')
            ->leftjoin('insurance_service_providers','insurance_service_providers.id','=','policies.isp_id')
            ->whereBetween('policy_details.created_at',[$date_from,$date_to])
            ->orderByDesc('id')
            ->get();
        return response()->json($policies);
    }

    public function claimReport(){

        return view('reports.claim-report');
    }

    public function getClaimReport(Request $request){
        $date_from = Carbon::parse($request->date_from)->startOfDay();
        $date_to = Carbon::parse($request->date_to)->endOfDay();

        $claims = Claim::query()
            ->select(['claims.*','policies.policy_number','vehicles.registration_number'])
            ->leftJoin('policies','policies.id','=','claims.policy_id')
            ->leftJoin('vehicles','vehicles.id','=','claims.vehicle_id')
            ->whereBetween('claims.created_at',[$date_from,$date_to])->orderByDesc('id')->get();

        return response()->json($claims);
    }
    public function paymentReport(){

        return view('reports.payments-report');
    }

    public function getPaymentReport(Request $request){
        $date_from = Carbon::parse($request->date_from)->startOfDay();
        $date_to = Carbon::parse($request->date_to)->endOfDay();

        $claims = Payment::query()
            ->select(['payments.*','policies.policy_number','vehicles.registration_number'])
            ->leftJoin('policy_details','policy_details.id','=','payments.policy_detail_id')
            ->leftJoin('policies','policies.id','=','policy_details.policy_id')
            ->leftJoin('vehicles','vehicles.id','=','policies.vehicle_id')
            ->whereBetween('payments.created_at',[$date_from,$date_to])->orderByDesc('id')->get();

        return response()->json($claims);
    }
}
