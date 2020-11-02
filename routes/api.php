<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('version', 'API\VersionController@index');

Route::group(['prefix' => 'v1'], function () {

    /* MEMBER */
    Route::post('register', 'API\MemberController@store')->name('member.register');

    Route::post('member/check', 'API\MemberController@check_member')->name('member.check');
    Route::post('member/activated', 'API\MemberController@activated_member_with_token')->name('member.activated');

    /* END MEMBER */

    /* CUSTOMER */

    Route::post('customer', 'API\CustomerController@login')->name('customer.login');
    Route::post('customer/register', 'API\CustomerController@store')->name('customer.register');
    Route::post('customer/otp', 'API\CustomerController@activated_by_otp')->middleware('auth:api-customer')->name('customer.otp');
    Route::post('customer/profile_picture', 'API\CustomerController@change_profile')->middleware('auth:api-customer')->name('customer.change_picture');
    Route::post('customer/logout', 'API\CustomerController@logout')->middleware('auth:api-customer')->name('customer.logout');
    Route::post('customer/dokumen_kelengkapan', 'API\CustomerController@upload_document')->middleware('auth:api-customer')->name('customer.dokumen');

    Route::get('customer', 'API\CustomerController@verified_auth')->middleware('auth:api-customer')->name('customer.verified');
    Route::get('customer/{id}', 'API\CustomerController@show')->middleware('auth:api-customer')->name('customer.detail');

    Route::put('customer/{id}', 'API\CustomerController@update')->middleware('auth:api-customer')->name('customer.update');

    Route::delete('customer/{id}', 'API\CustomerController@destroy')->middleware('auth:api-customer')->name('customer.destroy');

    /* END CUSTOMER */

    /* DRIVER */
    Route::post('driver', 'API\DriverController@login')->name('driver.login');
    Route::post('driver/register', 'API\DriverController@store')->name('driver.register');
    Route::post('driver/otp', 'API\DriverController@activated_by_otp')->middleware('auth:api-driver')->name('driver.otp');
    Route::post('driver/logout', 'API\DriverController@logout')->middleware('auth:api-driver')->name('driver.logout');
    Route::post('driver/dokumen_kelengkapan', 'API\DriverController@upload_document')->middleware('auth:api-driver')->name('driver.dokumen');


    Route::get('driver', 'API\DriverController@verified_auth')->middleware('auth:api-driver');
    Route::get('driver/{id}', 'API\DriverController@show')->middleware('auth:api-driver')->name('driver.detail');

    Route::put('driver/{id}', 'API\DriverController@update')->middleware('auth:api-driver')->name('driver.update');

    Route::delete('driver/{id}', 'API\DriverController@destroy')->middleware('auth:api-driver')->name('driver.destroy');
    /* END DRIVER */

    /* PPOB */
    Route::post('ppob/test_connection', 'API\PPOBController@test_connection')->middleware('auth:api-customer');
});

