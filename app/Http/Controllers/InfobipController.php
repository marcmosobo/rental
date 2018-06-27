<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use infobip\api\client\GetAccountBalance;
use infobip\api\configuration\BasicAuthConfiguration;

class InfobipController extends Controller
{
    public function getBalance(){
        $client = new GetAccountBalance(new BasicAuthConfiguration('samuel_nguro','samuel_nguro'));
        $response = $client->execute();

        return response()->json(number_format($response->getBalance(),2));
    }

    public function infoBipCallback(Request $request){

    }
}
