<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('/deliveryOrders', 'Api\DeliveryOrdersController@index');
});

Route::post('/deliveryOrders/submit', 'Api\DeliveryOrdersController@submitForm');
Route::get('/deliveryOrders/files', 'Api\DeliveryOrdersController@getFiles');

Route::post('/deliveryOrders/status/sd/received', 'Api\DeliveryOrdersController@setSDStatusReceived');
Route::post('/deliveryOrders/status/sd/verified', 'Api\DeliveryOrdersController@setSDStatusVerified');


Route::get('/catalogs/branches/list', 'Api\CatalogsController@branchesList');
Route::get('/catalogs/cities/list', 'Api\CatalogsController@citiesList');
Route::get('/catalogs/counties/list', 'Api\CatalogsController@countiesList');

Route::get('/products/list', 'Api\ProductsController@pList');

Route::post('/deliveryUsers/login', 'Api\DeliveryUsersController@login');