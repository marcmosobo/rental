<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Masterfile;
use App\Models\Payment;
use App\Models\PolicyDetail;
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
        return view('reports.property-statement');
    }
}
