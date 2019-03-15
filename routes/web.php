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



Route::prefix('products')->group(function () {
    Route::get('/', 'Web\ProductsController@index');
    Route::get('/list', 'Web\ProductsController@pList')->name('products.list');
    Route::get('/edit', 'Web\ProductsController@editForm')->name('products.edit');
    Route::post('/submit', 'Web\ProductsController@submitForm')->name('products.submit');
});



Route::get('test', 'TestController@index');