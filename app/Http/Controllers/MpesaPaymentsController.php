<?php

namespace App\Http\Controllers;

use App\Jobs\SendSms;
use App\Models\Masterfile;
use App\Models\Payment;
use Carbon\Carbon;
use Edwinmugendi\Sapamapay\MpesaApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Safaricom\Mpesa\Mpesa;

class MpesaPaymentController extends Controller
{

    public $access_token;
    private  $configs = array(
        'AccessToken' => '',
        'Environment' => 'sandbox',
        'Content-Type' => 'application/json',
        'Verbose' => 'true',
    );
    public function __construct()
    {

    }

    public function getPayment(Request $request){
        $input = $request->all();
        $input['tenant_id'] = null;
        $input['mf_id'] = null;
        $userName = $request->FirstName;
        $phone = $request->MSISDN;
        $p_number = '0'.ltrim($request->MSISDN,'254');
//        echo  $p_number;die;
        $mf = Masterfile::where('national_id',$input['BillRefNumber'])->orWhere('phone_number',$p_number)->first();
        if(!is_null($mf)){
            $input['account_number'] = $mf->national_id;
            $input['tenant_id'] = $mf->tenant_id;
            $input['mf_id'] = $mf->id;
            $userName = explode(' ',$mf->full_name)[0];
//                $phone = $mf->phone_number;

        }
//            print_r($mf);die;
        $input['payment_mode'] = "MPESA";

        $payment = Payment::create([
            'payment_mode'=>'MPESA',
            'account_number'=>$request->BillRefNumber,
            'ref_number'=>$request->TransID,
            'amount'=>$request->TransAmount,
            'paybill'=>$request->BusinessShortCode,
            'phone_number'=>$request->MSISDN,
            'BillRefNumber'=>$request->BillRefNumber,
            'TransID'=>$request->TransID,
            'TransTime'=>$request->TransTime,
            'FirstName'=>$request->FirstName,
            'MiddleName'=>$request->MiddleName,
            'LastName'=>$request->LastName,
            'tenant_id' => $input['tenant_id'],
            'received_on'=>Carbon::now(),
            'mf_id'=>$input['mf_id']
        ]);


//        SendSms::dispatch('Dear '.$userName. ' your payment of '.$request->TransAmount.' Ksh has been received. Pay your loans early to improve your rating.',$phone);
        return ['C2BPaymentConfirmationResult'=>'success'];
    }

    public function getPaymentValidation(Request $request){
//        $account = Masterfile::where('national_id',$request->BillRefNumber)->first();
//        if(!is_null($account)){
//            return $array = array(
//                'ResultCode' => '0',
//                'ResultDesc' => 'Service processing successful',
//            );
//        }
//        return $array = array(
//            'ResultCode' => '1',
//            'ResultDesc' => 'Service processing failed',
//        );

        return $array = array(
            'ResultCode' => '0',
            'ResultDesc' => 'Service processing successful',
        );
    }

    public function simulate(){
        $mpesa= new Mpesa();
        $c2bTransaction= $mpesa->c2b(600000, 'CustomerPayBillOnline', 1000, 254715862938, '21844232' );
        var_dump($c2bTransaction);
    }

    public function generateToken(){
        return $this->configs['AccessToken'] =  Mpesa::generateLiveToken();
    }

    public function registerUrls(){
//        $this->generateToken();
//        $mpesa = new MpesaApi();
//        $api = 'c2b_register_url';
//        $parameters = array(
//            'ValidationURL' => 'https://salasa.co.ke/getPaymentValidation',
//            'ConfirmationURL' => 'https://salasa.co.ke/getPayment',
//            'ResponseType' => 'Cancelled',
//            'ShortCode' => '881595',
//        );
//        $response = $mpesa->call($api, $this->configs, $parameters);
        $token = Mpesa::generateSandBoxToken();

//        $url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
        $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token)); //setting custom header


        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'ValidationURL' => 'https://mariteenterprisesltd.co.ke/getPaymentValidation',
            'ConfirmationURL' => 'https://mariteenterprisesltd.co.ke/getPayment',
            'ResponseType' => 'Completed',
            'ShortCode' => '600000',
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);
        print_r($curl_response);

        echo $curl_response;
    }

//    public function simulate(){
//        $token =
//        var_dump($token);
//    }
}
