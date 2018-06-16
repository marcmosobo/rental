<?php

namespace App\Http\Controllers;

use App\Models\Masterfile;
use App\Models\TicketLine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        print_r(session()->get('routes'));die;
        $employeesOnGround = 0;
//        if(LoggedUserController::getAccessLevel() == "ALL"){
//            $employeesOnGround = count(TicketLine::where([
//                ['date',Carbon::today()]
//            ])->get());
//        }else{
//            $employeesOnGround = count(TicketLine::where([
//                ['date',Carbon::today()],
//                ['ward_id',Auth::user()->ward_id]
//            ])->get());
//        }
        return view('home',[
//            'employeesOnGround'=>$employeesOnGround
        ]);
    }
}
