<?php

use App\Models\Role;
use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\Route;
use App\Models\Route;
use Illuminate\Support\Facades\DB;

class RoutesTableSeeder extends Seeder
{
    const SystemAdmin = 'SYSADMIN';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\RoleRoute::truncate();
        \Illuminate\Support\Facades\DB::table('routes')->delete();
        $admin = Role::where('code', self::SystemAdmin)->first();



//        #### Dashboard
        $dashboard = new Route();
        $dashboard->route_name = 'Dashboard';
        $dashboard->icon = 'fa-dashboard';
        $dashboard->sequence = 1;
        $dashboard->save();
        $dashboard_id = $dashboard->id;

        #### Dashboard child
        $analytics_dash = new Route();
        $analytics_dash->route_name = 'Analytics Dashboard';
        $analytics_dash->url = 'home';
        $analytics_dash->parent_route = $dashboard_id;
        $analytics_dash->save();
        $analytics_dash->roles()->attach($admin);


        ####### Configurations

        $parent = Route::create([
            'route_name'=> 'Configurations',
            'icon'=> 'fa-wrench',
            'sequence'=>2,
        ]);

        $child = Route::create([
            'route_name'=>'Service Bills',
            'parent_route' => $parent->id,
            'url'=>'serviceOptions'
        ]);
        $child->roles()->attach($admin);

        $child = Route::create([
            'route_name'=>'Banks',
            'parent_route' => $parent->id,
            'url'=>'banks'
        ]);
        $child->roles()->attach($admin);

        $child = Route::create([
            'route_name'=>'Event Messages',
            'parent_route' => $parent->id,
            'url'=>'eventMessages'
        ]);
        $child->roles()->attach($admin);

        ####### crm

        $parent = Route::create([
            'route_name'=> 'Broadcasts',
            'icon'=> 'fa-volume-up',
            'sequence'=>3,
        ]);

        $child = Route::create([
            'route_name'=>'Customer Messages',
            'parent_route' => $parent->id,
            'url'=>'customerMessages'
        ]);
        $child->roles()->attach($admin);


        ####### crm

        $parent = Route::create([
            'route_name'=> 'CRM',
            'icon'=> 'fa-users',
            'sequence'=>3,
        ]);

        $child = Route::create([
            'route_name'=>'All Landlords',
            'parent_route' => $parent->id,
            'url'=>'landlords'
        ]);
        $child->roles()->attach($admin);

        $child = Route::create([
            'route_name'=>'All Tenants',
            'parent_route' => $parent->id,
            'url'=>'tenants'
        ]);
        $child->roles()->attach($admin);

        $child = Route::create([
            'route_name'=>'All Staff',
            'parent_route' => $parent->id,
            'url'=>'staff'
        ]);
        $child->roles()->attach($admin);

        ####### property manager

        $parent = Route::create([
            'route_name'=> 'Property Manager',
            'icon'=> 'fa-home',
            'sequence'=>4,
        ]);

        $child = Route::create([
            'route_name'=>'All Properties',
            'parent_route' => $parent->id,
            'url'=>'properties'
        ]);
        $child->roles()->attach($admin);

        ####### Lease manager

        $parent = Route::create([
            'route_name'=> 'Lease Manager',
            'icon'=> 'fa-briefcase',
            'sequence'=>5,
        ]);

        $child = Route::create([
            'route_name'=>'All Leases',
            'parent_route' => $parent->id,
            'url'=>'leases'
        ]);
        $child->roles()->attach($admin);


        $child = Route::create([
            'route_name'=>'Terminated Leases',
            'parent_route' => $parent->id,
            'url'=>'terminatedLeases'
        ]);
        $child->roles()->attach($admin);


        ####### Bills and payments
        $parent = Route::create([
            'route_name'=> 'Payments & Bills',
            'icon'=> 'fa-money',
            'sequence'=>5,
        ]);

        $child = Route::create([
            'route_name'=>'All Bills',
            'parent_route' => $parent->id,
            'url'=>'billDetails'
        ]);
        $child->roles()->attach($admin);
//         $child = Route::create([
//            'route_name'=>'Pay Bills',
//            'parent_route' => $parent->id,
//            'url'=>'payBills'
//        ]);
//        $child->roles()->attach($admin);

        $child = Route::create([
            'route_name'=>'Cash Payments',
            'parent_route' => $parent->id,
            'url'=>'cashPayments'
        ]);
        $child->roles()->attach($admin);

        $child = Route::create([
            'route_name'=>'Mpesa Payments',
            'parent_route' => $parent->id,
            'url'=>'payments'
        ]);
        $child->roles()->attach($admin);

        ####### Reports
        $parent = Route::create([
            'route_name'=> 'Reports',
            'icon'=> 'fa-search',
            'sequence'=>5,
        ]);

        $child = Route::create([
            'route_name'=>'Tenant Statement',
            'parent_route' => $parent->id,
            'url'=>'tenantStatement'
        ]);
        $child->roles()->attach($admin);

        $child = Route::create([
            'route_name'=>'Tenant Arrears',
            'parent_route' => $parent->id,
            'url'=>'tenantArrears'
        ]);
        $child->roles()->attach($admin);

        $child = Route::create([
            'route_name'=>'Property Statement',
            'parent_route' => $parent->id,
            'url'=>'plotStatement'
        ]);
        $child->roles()->attach($admin);

        $child = Route::create([
            'route_name'=>'Landlord Settlement Report',
            'parent_route' => $parent->id,
            'url'=>'landlordSettlementStatement'
        ]);
        $child->roles()->attach($admin);

        #### user management
        $user_mngt = new Route();
        $user_mngt->route_name = 'User Manager';
        $user_mngt->icon = 'fa-user';
        $user_mngt->sequence = 6;
        $user_mngt->save();
        $user_mngt_id = $user_mngt->id;
//
        #### user management children
        $all_user = new Route();
        $all_user->route_name = 'All Users';
        $all_user->url = 'users';
        $all_user->parent_route = $user_mngt_id;
        $all_user->save();
        $all_user->roles()->attach($admin);

        $roles = new Route();
        $roles->route_name = 'Manage User Roles';
        $roles->url = 'roles';
        $roles->parent_route = $user_mngt_id;
        $roles->save();
        $roles->roles()->attach($admin);

//////        #### system
//        $system = new Route();
//        $system->route_name = 'System Settings';
//        $system->icon = 'fa-cogs';
//        $system->sequence = 7;
//        $system->save();
//        $system_id = $system->id;
//
//        #### system children
//        $routes = new Route();
//        $routes->route_name = 'System Routes';
//        $routes->url = 'routes';
//        $routes->parent_route = $system_id;
//        $routes->save();
//        $routes->roles()->attach($admin);
    }
}
