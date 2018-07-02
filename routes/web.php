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
Route::any('searchBills', 'PayBillController@searchBills');
Route::get('receipt/{id}', 'PayBillController@receipt');

##############mpesa

Route::post('getPaymentValidation',"MpesaPaymentController@getPaymentValidation");
Route::post('getPayment',"MpesaPaymentController@getPayment");
Route::get('registerUrls',"MpesaPaymentController@registerUrls");
Route::get('simulate',"MpesaPaymentController@simulate");

Route::resource('staff', 'StaffController');

Route::resource('eventMessages', 'EventMessageController');

#### Reports

Route::get('tenantStatement','ReportController@tenantStatement');
Route::get('propertyStatement','ReportController@propertyStatement');

Route::post('getPropertyStatement','ReportController@getPropertyStatement');
Route::post('getTenantStatement','ReportController@getTenantStatement');

//imports
Route::get('import','LandlordController@import');
Route::post('importMasterfiles','LandlordController@importMasterfiles');

//infobip
Route::get('infobipBalance','InfobipController@getBalance');
Route::post('infoBipCallback','InfobipController@infoBipCallback');



Route::resource('customerMessages', 'CustomerMessageController');

Route::resource('banks', 'BankController');

Route::resource('landlordSettlements', 'LandlordSettlementController');

Route::delete('reverse-lease/{id}','LeaseController@reverse');

Route::resource('terminatedLeases', 'TerminatedLeaseController');

Route::patch('processPayment/{id}','PaymentController@processPayment');