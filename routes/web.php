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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    $routes = [
        ['module' => 'customers', 'controller' => 'CustomerController'],
        ['module' => 'products', 'controller' => 'ProductController'],
        ['module' => 'categories', 'controller' => 'CategoryController'],
        ['module' => 'tags', 'controller' => 'TagController'],
        ['module' => 'orders', 'controller' => 'OrderController'],
        ['module' => 'payment-methods', 'controller' => 'PaymentMethodController'],
        ['module' => 'user', 'controller' => 'UserController'],
    ];

    foreach ($routes as $route) {
        Route::group(['prefix' => $route['module']], function () use ($route) {
            Route::get('/', "{$route['controller']}@index")->middleware("permission:read-{$route['module']}")->name("{$route['module']}.index");
            Route::get('/json', "{$route['controller']}@json")->middleware("permission:read-{$route['module']}")->name("{$route['module']}.json");
            Route::get('/create', "{$route['controller']}@create")->middleware("permission:create-{$route['module']}")->name("{$route['module']}.create");
            Route::post('/store', "{$route['controller']}@store")->middleware("permission:create-{$route['module']}")->name("{$route['module']}.store");
            Route::get('/edit/{id}', "{$route['controller']}@edit")->middleware("permission:update-{$route['module']}")->name("{$route['module']}.edit");
            Route::put('/{id}', "{$route['controller']}@update")->middleware("permission:update-{$route['module']}")->name("{$route['module']}.update");
            Route::delete('/{id}', "{$route['controller']}@destroy")->middleware("permission:delete-{$route['module']}")->name("{$route['module']}.destroy");
        });
    }

    Route::get('/charts', 'ChartController@index')->middleware('permission:read-charts');
});
