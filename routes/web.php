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
Route::get('tenantArrears','ReportController@tenantArrears');
Route::get('plotStatement','ReportController@plotStatement');
Route::get('landlordSettlementStatement','ReportController@landlordSettlementStatement');
Route::get('rentpay','ReportController@rentPayments');
Route::get('dailyPayments','ReportController@mpesaPayments');
Route::get('landlordPSettlements','ReportController@landlordPSettlements');

Route::any('getPropertyStatement','ReportController@getPropertyStatement');
Route::any('getTenantStatement','ReportController@getTenantStatement');
Route::any('getTenantArrears','ReportController@getTenantArrears');
Route::any('getPlotStatement','ReportController@getPlotStatement');
Route::any('getLandlordStatement','ReportController@getLandlordStatement');
Route::any('getrentPayment','ReportController@getrentPayments');
Route::any('getDailyPayments','ReportController@getDailyPaymentsByDate');
Route::any('getLandlordPSettlements','ReportController@getLandlordPSettlements');
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
Route::patch('reversePayment/{id}','PaymentController@reversePayment');

Route::resource('unprocessedPayments', 'UnprocessedPaymentController');


Route::resource('paymentTransfers', 'PaymentTransferController');

Route::get('crossCheckTrans','PaymentController@crossCheck');
Route::any('crossCheckPayments','PaymentController@crossCheckPayments');
Route::post('importTransactions','PaymentController@importPayments');

Route::get('bankStatement','ReportController@bankStatement');

Route::any('getBankStatement','ReportController@getBankStatement');

Route::resource('expenditures', 'ExpenditureController');

Route::resource('propertyExpenditures', 'PropertyExpenditureController');

Route::resource('landlordRemittances', 'LandlordRemittanceController');

Route::resource('propertyTypes', 'PropertyTypeController');

Route::resource('propertyListings', 'PropertyListingController');

Route::resource('customers', 'CustomerController');

Route::resource('soldProperties', 'SoldPropertyController');

Route::resource('openingBalances', 'OpeningBalanceController');

Route::get('remittance','ReportController@landlordRemittance');
Route::any('getRemittance','ReportController@getLandlordRemittanceStatement');


Route::get('landlord-plot-report','ReportController@landlordPlotStatement');
Route::any('getLandlordPlotStatement','ReportController@getLandlordPlotStatement');


Route::get('rent-property-statement','ReportController@rentPropertyStatement');
Route::any('getRentPropertyStatement','ReportController@getRentPropertyStatement');


Route::resource('depositRefunds', 'DepositRefundController');
Route::resource('depositRefunds', 'DepositRefundController');

Route::get('depositReport','ReportController@depositReport');
Route::any('getDepositReport','ReportController@getDepositReport');

