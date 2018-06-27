<?php

namespace App\Http\Controllers;

use App\Models\CustomerMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $input = $request->all();
//        Log::info($input['results']);


        $result =$input['results'][0];
        $message = CustomerMessage::find($result['callbackData']);
        $message->status = ['status']['name'];
        $message->smsCount = ['smsCount'];
        $message->message_id = ['messageId'];
        $message->save();


    }
}
