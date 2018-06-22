<?php

namespace App\Jobs;

use App\Models\Masterfile;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ImportTenants implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $_record;
    private  $p_number;
    public function __construct($record,$p_number)
    {
        $this->_record = $record;
        $this->p_number = $p_number;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(empty($this->_record['national_id']) || $this->_record['national_id'] === ''){
            $this->_record['national_id'] = null;
        }
        Masterfile::create([
            'full_name'=>$this->_record['name'],
            'national_id'=>$this->_record['national_id'],
            'phone_number'=>$this->p_number,
            'b_role'=>tenant,
            'created_by'=>1,
            'client_id'=>1,
            'gender'=>'Male'
        ]);
    }
}
