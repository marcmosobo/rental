<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    const sys_admin = 'SYSADMIN';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accessL = \App\Models\AccessLevel::where('code','ALL')->first();
        $limited = \App\Models\AccessLevel::where('code','LIMITED')->first();
        $client = \App\Models\Client::first();
        Role::create(['name' => 'System Admin', 'code' => self::sys_admin,
            'access_level_id'=> $accessL->id,'client_id'=>$client->id]);
        Role::create(['name' => 'Admin', 'code' => core_admin,'access_level_id'=> $accessL->id,'client_id'=>$client->id]);
        Role::create(['name' => 'Landlord', 'code' => landlord,'access_level_id'=> $limited->id,'client_id'=>$client->id]);
        Role::create(['name' => 'Property Manager', 'code' => pm,'access_level_id'=> $accessL->id,'client_id'=>$client->id]);
    }
}
