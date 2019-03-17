<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// ПРОДУКТЫ --начало
Route::prefix('products')->group(function () {
    Route::get('/', 'Web\ProductsController@index')->name('products');
    Route::get('/list', 'Web\ProductsController@pList')->name('products.list');
    Route::get('/edit', 'Web\ProductsController@editForm')->name('products.edit');
    Route::post('/submit', 'Web\ProductsController@submitForm')->name('products.submit');
    Route::post('/delete', 'Web\ProductsController@delete')->name('products.delete');
});
// ПРОДУКТЫ --конец


// КУРЬЕРСКИЕ КОМПАНИИ --начало
Route::prefix('deliveryCompanies')->group(function () {
    Route::get('/', 'Web\DeliveryCompaniesController@index')->name('deliveryCompanies');
    Route::get('/list', 'Web\DeliveryCompaniesController@pList')->name('deliveryCompanies.list');
    Route::get('/edit', 'Web\DeliveryCompaniesController@editForm')->name('deliveryCompanies.edit');
    Route::post('/submit', 'Web\DeliveryCompaniesController@submitForm')->name('deliveryCompanies.submit');
    Route::post('/delete', 'Web\DeliveryCompaniesController@delete')->name('deliveryCompanies.delete');
});
// КУРЬЕРСКИЕ КОМПАНИИ --конец



Route::get('test', 'TestController@index');