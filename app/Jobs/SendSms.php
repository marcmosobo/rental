<?php

namespace App\Jobs;

//use App\Models\Sms;
use App\Models\CustomerMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use infobip;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $_sms;
    public $tries = 2;
    protected  $password = 'samuel_nguro';
    protected $username = 'samuel_nguro';
    protected $_message;
    protected $to;
    protected $message_id;
    protected $mf;
    public function __construct($m,$to,$mf)
    {
        $this->_message = $m;
        $this->to = $to;
        $this->mf = $mf;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        Log::info('sending sms');
        $client = new infobip\api\client\SendMultipleTextualSmsAdvanced(new infobip\api\configuration\BasicAuthConfiguration($this->username, $this->password));
        $destination = new infobip\api\model\Destination();
//        if($this->_sms->)
        if($this->to[0] ==='0'){
            $this->to = '254'.ltrim($this->to,'0');
        }
//        var_dump($this->to);die();
        $destination->setTo($this->to);

        $message = new infobip\api\model\sms\mt\send\Message();
        $message->setFrom("VOOMSMS");
        $message->setDestinations([$destination]);
        $message->setText($this->_message);
        $message->setNotifyUrl(url('infoBipCallback'));

        $Cmessage = CustomerMessage::create([
            'phone_number'=>$this->to,
            'name'=>$this->mf->full_name,
            'user_id'=>$this->mf->id,
            'tenant_id'=> $this->mf->client_id,
            'message_type'=>'SMS',
            'message'=>$this->_message,
//            'message_id'=>$response->getMessages()[0]->getMessageId(),
//            'smsCount'=>$response->getMessages()[0]->getSmsCount(),
//            'status'=>$response->getMessages()[0]->getStatus()->getName(),
            'sent'=>true
        ]);
        $message->setCallbackData($Cmessage->id);

        $requestBody = new infobip\api\model\sms\mt\send\textual\SMSAdvancedTextualRequest();
        $requestBody->setMessages([$message]);

        $response = $client->execute($requestBody);

//        print_r($response->getMessages()[0]->getMessageId());die;


    }

}
