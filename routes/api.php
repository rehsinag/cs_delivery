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

Route::group(['middleware' => ['sic']], function () {
    Route::get('/test', 'Api\TestController@index');

    // API для СИК --начало
    Route::prefix('/deliveryOrders')->group(function (){
        Route::post('/create', 'Api\DeliveryOrdersController@create');
        Route::post('/queueStatusComplete', 'Api\DeliveryOrdersController@queueStatusComplete');
        Route::post('/files', 'Api\DeliveryOrdersController@getFiles');
        Route::post('/answerFile', 'Api\DeliveryOrdersController@answerFile');
        Route::post('/bankStatus', 'Api\DeliveryOrdersController@bankStatus');
    });
    // API для СИК --конец
});

//Route::group(['middleware' => ['jwt.auth']], function () {
//    Route::prefix('/files')->group(function (){
//        Route::post('/upload', 'MobileApi\FilesController@upload');
//        Route::get('/download/{fileId}', 'MobileApi\FilesController@download');
//    });
//});

Route::prefix('/files')->group(function (){
    Route::post('/upload', 'MobileApi\FilesController@upload');
    Route::get('/download/{fileId}', 'MobileApi\FilesController@download');
});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//Route::middleware(['auth:api'])->group(function () {
//    Route::get('/deliveryOrders', 'Api\DeliveryOrdersController@index');
//});
//
//Route::get('/test', 'Api\TestController@index');
//
//Route::post('/deliveryOrders/submit', 'Api\DeliveryOrdersController@submitForm');
//Route::get('/deliveryOrders/files', 'Api\DeliveryOrdersController@getFiles');
//Route::post('/deliveryOrders/uploadFiles', 'Api\DeliveryOrdersController@uploadFiles');
//Route::post('/deliveryOrders/changeComment', 'Api\DeliveryOrdersController@changeComment');
//Route::post('/deliveryOrders/changeStatus', 'Api\DeliveryOrdersController@changeStatus');
//Route::post('/deliveryOrders/sicStatusComplete', 'Api\DeliveryOrdersController@changeSicStatusToComplete');
//
//Route::post('/deliveryOrders/status/sd/received', 'Api\DeliveryOrdersController@setSDStatusReceived');
//Route::post('/deliveryOrders/status/sd/verified', 'Api\DeliveryOrdersController@setSDStatusVerified');
//
//
//Route::get('/catalogs/branches/list', 'Api\CatalogsController@branchesList');
//Route::get('/catalogs/cities/list', 'Api\CatalogsController@citiesList');
//Route::get('/catalogs/counties/list', 'Api\CatalogsController@countiesList');
//
//Route::get('/products/list', 'Api\ProductsController@pList');
//
//Route::post('/deliveryUsers/login', 'Api\DeliveryUsersController@login');