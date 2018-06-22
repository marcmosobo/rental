<?php

use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Client::create([
            'name'=>'OpenPath Solutions',
            'email'=>'info@openpathsolutions.co.ke',
            'phone_number'=>'0715862938',
            'location'=>'Westlands'
        ]);
        \App\Models\Client::create([
            'name'=>'Marite Enterprises Ltd',
            'email'=>'info@mariteenterprisesltd.co.ke',
            'phone_number'=>'0715862938',
            'location'=>'Nanyuki'
        ]);
    }
}
