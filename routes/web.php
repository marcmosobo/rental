<?php
Route::get('/','HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('routes', 'RouteController');

Route::get('reset-pass','UserController@resetPassword');
Route::post('reset-post','UserController@resetPost');

##### Roles
Route::resource('roles', 'RoleController');
Route::get('getRoutes/{id}',"RoleController@getRoutes");
//assigning permissions
Route::any('/give-permission/','RoleController@assignPermissions');
Route::resource('roles', 'RoleController')->middleware('validate_routes');
Route::resource('users', 'UserController');
Route::get('dashboard','DashboardController@index');
Route::get('unAuthorized',"LoggedUserController@unAuthorized");

Route::resource('accessLevels', 'AccessLevelController');

Route::resource('masterfiles', 'MasterfileController');

Route::resource('clients', 'ClientController');











Route::resource('reminders', 'ReminderController');











Route::get('getVehicles/{id}','PolicyDetailController@getVehicles');







//Route::resource('getClaimReport', 'ClaimInjuredPersonController');
//




Route::get('getPolicy/{id}','PaymentController@getPolicy');

Route::get('policiesReport','ReportController@policies');
Route::post('getPoliciesReport','ReportController@getPoliciesReport');
Route::post('getClaimReport','ReportController@getClaimReport');
Route::get('claimReport','ReportController@claimReport');
Route::post('getClaimReport','ReportController@getClaimReport');

Route::get('paymentReport','ReportController@paymentReport');
Route::post('getPaymentsReport','ReportController@getPaymentReport');

Route::resource('clients', 'ClientController');

Route::resource('landlords', 'LandlordController');

Route::resource('tenants', 'TenantController');

Route::resource('properties', 'PropertyController');

Route::resource('propertyUnits', 'PropertyUnitController');
Route::get('units/{id}', 'PropertyUnitController@propertyUnits');

Route::resource('serviceOptions', 'ServiceOptionController');

Route::resource('unitServiceBills', 'UnitServiceBillController');
Route::get('unitBills/{id}', 'UnitServiceBillController@unitServiceBills');

Route::resource('leases', 'LeaseController');
Route::get('getUnits/{id}', 'LeaseController@getUnits');
Route::get('getBills/{id}', 'LeaseController@getBills');

Route::resource('bills', 'BillController');

Route::resource('billDetails', 'BillDetailController');

Route::resource('payments', 'PaymentController');

Route::resource('customerAccounts', 'CustomerAccountController');

Route::resource('cashPayments', 'CashPaymentController');

Route::resource('payBills', 'PayBillController');