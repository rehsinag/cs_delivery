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

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'Web\HomeController@index');
    Route::get('/home', 'Web\HomeController@index')->name('home');

    // СПРАВОЧНИКИ СИСТЕМЫ --начало
    Route::prefix('catalogs')->group(function () {
       Route::get('/branches', 'Web\CatalogsController@branchesIndex')->name('catalogs.branches');
       Route::get('/branches/list', 'Web\CatalogsController@branchesList')->name('catalogs.branches.list');
       Route::get('/branches/edit', 'Web\CatalogsController@branchesEditForm')->name('catalogs.branches.edit');
       Route::post('/branches/submit', 'Web\CatalogsController@branchesSubmitForm')->name('catalogs.branches.submit');
       Route::post('/branches/delete', 'Web\CatalogsController@branchesDelete')->name('catalogs.branches.delete');

       Route::get('/cities', 'Web\CatalogsController@citiesIndex')->name('catalogs.cities');
       Route::get('/cities/list', 'Web\CatalogsController@citiesList')->name('catalogs.cities.list');
       Route::get('/cities/edit', 'Web\CatalogsController@citiesEditForm')->name('catalogs.cities.edit');
       Route::post('/cities/submit', 'Web\CatalogsController@citiesSubmitForm')->name('catalogs.cities.submit');
       Route::post('/cities/delete', 'Web\CatalogsController@citiesDelete')->name('catalogs.cities.delete');

       Route::get('/counties', 'Web\CatalogsController@countiesIndex')->name('catalogs.counties');
       Route::get('/counties/list', 'Web\CatalogsController@countiesList')->name('catalogs.counties.list');
       Route::get('/counties/edit', 'Web\CatalogsController@countiesEditForm')->name('catalogs.counties.edit');
       Route::post('/counties/submit', 'Web\CatalogsController@countiesSubmitForm')->name('catalogs.counties.submit');
       Route::post('/counties/delete', 'Web\CatalogsController@countiesDelete')->name('catalogs.counties.delete');
    });
    // СПРАВОЧНИКИ СИСТЕМЫ --конец

    // УПРАВЛЕНИЕ ПОЛЬЗОВАТЕЛЯМИ СИСТЕМЫ --начало
    Route::prefix('adminUsers')->group(function () {
        Route::get('/', 'Web\AdminUsersController@index')->name('adminUsers');
        Route::get('/list', 'Web\AdminUsersController@pList')->name('adminUsers.list');
        Route::get('/edit', 'Web\AdminUsersController@editForm')->name('adminUsers.edit');
        Route::post('/submit', 'Web\AdminUsersController@submitForm')->name('adminUsers.submit');
        Route::post('/delete', 'Web\AdminUsersController@delete')->name('adminUsers.delete');
    });
// УПРАВЛЕНИЕ ПОЛЬЗОВАТЕЛЯМИ СИСТЕМЫ --конец

// УПРАВЛЕНИЕ РОЛЯМИ ПОЛЬЗОВАТЕЛЕЙ СИСТЕМЫ --начало
    Route::prefix('adminUsersRoles')->group(function () {
        Route::get('/', 'Web\AdminUsersRolesController@index')->name('adminUsersRoles');
        Route::get('/list', 'Web\AdminUsersRolesController@pList')->name('adminUsersRoles.list');
        Route::get('/edit', 'Web\AdminUsersRolesController@editForm')->name('adminUsersRoles.edit');
        Route::post('/submit', 'Web\AdminUsersRolesController@submitForm')->name('adminUsersRoles.submit');
        Route::post('/delete', 'Web\AdminUsersRolesController@delete')->name('adminUsersRoles.delete');
    });
// УПРАВЛЕНИЕ РОЛЯМИ ПОЛЬЗОВАТЕЛЕЙ СИСТЕМЫ --конец

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

// КУРЬЕРЫ --начало
    Route::prefix('deliveryUsers')->group(function () {
        Route::get('/', 'Web\DeliveryUsersController@index')->name('deliveryUsers');
        Route::get('/list', 'Web\DeliveryUsersController@pList')->name('deliveryUsers.list');
        Route::get('/edit', 'Web\DeliveryUsersController@editForm')->name('deliveryUsers.edit');
        Route::post('/submit', 'Web\DeliveryUsersController@submitForm')->name('deliveryUsers.submit');
        Route::post('/delete', 'Web\DeliveryUsersController@delete')->name('deliveryUsers.delete');
    });
// КУРЬЕРЫ --конец


    // ЗАЯВКИ --начало
    Route::prefix('deliveryOrders')->group(function () {
        Route::get('/', 'Web\DeliveryOrdersController@index')->name('deliveryOrders');
        Route::get('/list', 'Web\DeliveryOrdersController@pList')->name('deliveryOrders.list');
        Route::get('/edit', 'Web\DeliveryOrdersController@editForm')->name('deliveryOrders.edit');
        Route::post('/submit', 'Web\DeliveryOrdersController@submitForm')->name('deliveryOrders.submit');
        Route::post('/delete', 'Web\DeliveryOrdersController@delete')->name('deliveryOrders.delete');
    });
    // ЗАЯВКИ --конец



    Route::get('test', 'TestController@index');
});


