<?php

namespace App\Http\Controllers;

use App\Jobs\SendSms;
use App\Models\CustomerAccount;
use App\Models\Lease;
use App\Models\Masterfile;
use App\Models\Payment;
use App\Models\Property;
use App\Models\PropertyUnit;
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
        'Environment' => 'live',
        'Content-Type' => 'application/json',
        'Verbose' => 'true',
    );
    public function __construct()
    {

    }

    public function getPayment(Request $request){
        $input = $request->all();
        $input['client_id'] = null;
        $input['mf_id'] = null;
        $userName = $request->FirstName;
        $phone = $request->MSISDN;
        $p_number = '0'.ltrim($request->MSISDN,'254');
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
            'client_id' => $input['client_id'],
            'received_on'=>Carbon::now(),
            'mf_id'=>$input['mf_id']
        ]);

        //search for unit number
        $propertyUnit = PropertyUnit::where('unit_number',$input['BillRefNumber'])->first();
        if(!is_null($propertyUnit)){
            //get lease
            $lease = Lease::where('unit_id',$propertyUnit->id)
                ->where('status',true)->first();
            if(is_null($lease)){
                $lease = Lease::where('unit_id',$propertyUnit->id)->first();
            }

            //get tenant
            $tenant = Masterfile::find($lease->tenant_id);
            $input['client_id'] = $tenant->client_id;
            $input['mf_id'] = $tenant->id;
            $userName = explode(' ',$tenant->full_name)[0];

            DB::transaction(function()use($input,$tenant,$lease,$propertyUnit,$payment){
                $acc = CustomerAccount::create([
                    'tenant_id'=>$tenant->id,
                    'lease_id'=>$lease->id,
                    'unit_id'=>$propertyUnit->id,
                    'payment_id'=>$payment->id,
                    'ref_number'=>$payment->ref_number,
                    'transaction_type'=>debit,
                    'amount'=>$payment->amount,
                ]);

                $payment->status = true;
                $payment->house_number = $propertyUnit->unit_number;
                $payment->tenant_id = $tenant->id;
                $payment->client_id = $input['client_id'];
                $payment->save();
            });
            SendSms::dispatch('Dear '.$userName. ' your payment of '.$request->TransAmount.' Ksh has been received. Regards Marite Enterprises.',$phone);

        }else{
            //try with phone number
            $mf = Masterfile::where('phone_number',$p_number)->first();
            if(!is_null($mf)){
                $input['lease_id'] = null;
                $input['unit_id'] =null;
                $lease = Lease::where('tenant_id',$mf->id)->where('status',true)->first();
                if(is_null($lease)){
                    $lease = Lease::where('tenant_id',$mf->id)->first();
                }

                if(!is_null($lease)){
                    $input['lease_id'] = $lease->id;
                    $input['unit_id'] = $lease->unit_id;
                }
                DB::transaction(function ()use($input,$mf,$payment){
                    $acc = CustomerAccount::create([
                        'tenant_id'=>$mf->id,
                        'lease_id'=>$input['lease_id'],
                        'unit_id'=>$input['unit_id'],
                        'payment_id'=> $payment->id,
                        'ref_number'=>$payment->ref_number,
                        'transaction_type'=>debit,
                        'amount'=>$payment->amount,
                    ]);
                    $payment->house_number = $input['unit_id'];
                    $payment->tenant_id = $mf->id;
                    $payment->client_id = $mf->client_id;
                    $payment->status = true;
                    $payment->save();
                });
            }
            SendSms::dispatch('Dear '.$userName. ' your payment of '.$request->TransAmount.' Ksh has been received. Regards Marite Enterprises.',$phone);
        }

//        SendSms::dispatch('Dear '.$userName. ' your payment of '.$request->TransAmount.' Ksh has been received. Regards Marite Enterprises.',$phone);
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
        $c2bTransaction= $mpesa->c2b(196094, 'CustomerPayBillOnline', 1000, 254715862938, '21844232' );
        var_dump($c2bTransaction);
    }

    public function generateToken(){
        return $this->configs['AccessToken'] =  Mpesa::generateLiveToken();
    }

    public function registerUrls(){
        $token = Mpesa::generateLiveToken();

        $url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
//        $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token)); //setting custom header


        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'ValidationURL' => 'https://mariteenterprisesltd.co.ke/getPaymentValidation',
            'ConfirmationURL' => 'https://mariteenterprisesltd.co.ke/getPayment',
            'ResponseType' => 'Cancelled',
            'ShortCode' => '196094',
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
