<?php

namespace App\Jobs;

//use App\Models\Sms;
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
    protected  $password = 'k1nuth1a';
    protected $username = 'OpenPath';
    protected $_message;
    protected $to;
    protected $message_id;
    public function __construct($m,$to)
    {
        $this->_message = $m;
        $this->to = $to;
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
//        $message->setNotifyUrl(url('infobip-callback/'.$this->message_id));

        $requestBody = new infobip\api\model\sms\mt\send\textual\SMSAdvancedTextualRequest();
        $requestBody->setMessages([$message]);
        $response = $client->execute($requestBody);
//        Log::info($response);
    }

//    public function failed(Excep $exception)
//    {
////         Send user notification of failure, etc...
//    }
}
