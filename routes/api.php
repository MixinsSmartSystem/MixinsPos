<?php

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('signup', 'App\Http\Controllers\AuthController@signup');
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
});
Route::apiResource('purchases', 'App\Http\Controllers\Api\PurchaseController');
Route::apiResource('bills', 'App\Http\Controllers\Api\BillController');

//Route::apiResource('typeStocks', 'App\Http\Controllers\Api\BillController');


Route::apiResource('types', 'App\Http\Controllers\Api\TypeController');
Route::get('findTypeByBarcode/{id}', 'App\Http\Controllers\Api\TypeController@findTypeByBarcode');
Route::apiResource('mainTypes', 'App\Http\Controllers\Api\MainTypesController');
Route::apiResource('customers', 'App\Http\Controllers\Api\CustomerController');
Route::apiResource('customerPay', 'App\Http\Controllers\Api\CustomerPayController');

Route::apiResource('suppliers', 'App\Http\Controllers\Api\SupplierController');
Route::apiResource('mixins', 'App\Http\Controllers\Api\MixinsController');
Route::apiResource('typeStocks', 'App\Http\Controllers\Api\TypeStockController');
Route::apiResource('payMethods', 'App\Http\Controllers\Api\PayMethodsController');
Route::apiResource('users', 'App\Http\Controllers\Api\UserController');
Route::apiResource('workers', 'App\Http\Controllers\Api\WorkerController');
Route::apiResource('roles', 'App\Http\Controllers\Api\MixinsRolesController');
Route::apiResource('user/roles', 'App\Http\Controllers\Api\UserRolesController');
Route::apiResource('offers', 'App\Http\Controllers\Api\OfferController');
Route::apiResource('units', 'App\Http\Controllers\Api\UnitsController');
Route::apiResource('saleType', 'App\Http\Controllers\Api\SalesTypeController');
Route::apiResource('expenses', 'App\Http\Controllers\Api\ExpenseController');

Route::get('active/user/roles/{id}', 'App\Http\Controllers\Api\UserController@roles');
Route::get('user/roles/{id}', 'App\Http\Controllers\Api\MixinsRolesController@findRoleByUserId');


//Reports Route
Route::Get('/bill/report/{period}/{form}/{to}', 'App\Http\Controllers\Api\BillController@billsReport');
Route::Get('/bill/purchases/report/{period}/{form}/{to}', 'App\Http\Controllers\Api\PurchaseController@purchasesBillReport');

Route::Get('/customer/report/{form}/{to}/{id}', 'App\Http\Controllers\Api\CustomerController@customerReport');
Route::Get('/customer/pay/{form}/{to}/{id}', 'App\Http\Controllers\Api\CustomerController@customerCashReport');

//ActionController
Route::Get('/action/{id}', 'App\Http\Controllers\Api\ActionController@addToExitStock');
Route::Get('/action/find/{id}', 'App\Http\Controllers\Api\ActionController@findTypeByCodeOrId');
Route::Get('/action/like/{like}', 'App\Http\Controllers\Api\ActionController@findTypeByLike');
Route::Get('/action/findBillWithTypeId/{like}', 'App\Http\Controllers\Api\ActionController@findBillWithTypeId');

Route::Get('/supplierPay', 'App\Http\Controllers\Api\ActionController@index');
Route::Get('/supplierPay/{id}/{pay}', 'App\Http\Controllers\Api\ActionController@supplierPay');
Route::Get('/AllCategories', 'App\Http\Controllers\Api\ActionController@getAllCategories');

Route::Get('/action/check/{id}', 'App\Http\Controllers\Api\ActionController@checkIfTypeAddedToItemRequestToday');
Route::Get('/item/request/report/{form}/{to}/{status}', 'App\Http\Controllers\Api\ActionController@allRequests');
Route::Get('/action/all/customers', 'App\Http\Controllers\Api\ActionController@findCustomers');

Route::Get('action/customerPay/{type}', 'App\Http\Controllers\Api\ActionController@PaidDetails');
Route::Get('action/offerType/{id}', 'App\Http\Controllers\Api\ActionController@getOfferType');
Route::Get('action/findBillById/{id}', 'App\Http\Controllers\Api\ActionController@findBillById');
