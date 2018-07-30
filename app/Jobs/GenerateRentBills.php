<?php

namespace App\Jobs;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\CustomerAccount;
use App\Models\Lease;
use App\Models\UnitServiceBill;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateRentBills implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //get active leases
        $leases = Lease::where('status',true)->get();
        if(count($leases)){
            //for each lease get the service options/bills that interval is set to monthly
            foreach ($leases as $lease){
                $bills = UnitServiceBill::where('unit_id',$lease->unit_id)->where('period',monthly)->get();
                if(count($bills)){
                    $monthlyBill = Bill::create([
                        'lease_id'=>$lease->id,
                        'tenant_id'=>$lease->tenant_id,
                        'property_id'=> $lease->property_id,
                        'description'=> 'Monthly Rent Bill',
                        'total'=>$bills->sum('amount')
                    ]);
                    foreach ($bills as $bill){
                        $billDetail = BillDetail::create([
                            'bill_id'=> $monthlyBill->id,
                            'service_bill_id'=> $bill->service_bill_id,
                            'amount'=>$bill->amount,
                            'balance'=>$bill->amount,
                            'status'=>false,
                            'bill_date'=>$input['start_date']
                        ]);
                    }
                    $customerAccount = CustomerAccount::create([
                        'tenant_id'=>$input['tenant_id'],
                        'lease_id'=>$lease->id,
                        'unit_id'=> $input['unit_id'],
                        'bill_id'=>$bill->id,
                        'transaction_type'=>credit,
                        'amount'=>$bills->sum('amount'),
                        'balance'=>$bills->sum('amount'),
                        'date'=>$input['start_date']
                    ]);

                }
            }
        }
    }
}
