<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){



        Route::name('dashboard.')->prefix('dashboard')->group(function () {

            Route::group(['middleware' => ['auth:web']], function()
            {

                // start dashboard
                Route::get('/','DashboardController@index')->name('index');

                // start roles and permision
                Route::resource('roles','RoleController');
                Route::resource('users','UserController')->except('show');

                // start categories
                Route::resource('categories','CategoryController')->except('show');

                //start product
                Route::resource('product','ProductController')->except('show');

                //start client
                Route::resource('client','ClientController')->except('show');
                Route::resource('client.orders','Client\OrderController')->except('show','index');

                //start orders
                Route::resource('orders','OrderController')->except('show');
                Route::get('orders/{client}','OrderController@product')->name('orders.product');

            });

        });


});

