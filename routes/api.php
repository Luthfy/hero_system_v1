<?php

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

    Route::post('register', 'API\MemberController@store')->name('member.register');

    Route::post('member/check', 'API\MemberController@check_member')->name('member.check');
    Route::post('member/activated', 'API\MemberController@activated_member_with_token')->name('member.activated');

    Route::post('customer', 'API\CustomerController@login')->name('customer.login');
    Route::post('customer/register', 'API\CustomerController@store')->name('customer.register');
    Route::post('customer/otp', 'API\CustomerController@activated_by_otp')->middleware('auth:api-customer')->name('customer.otp');
    Route::post('customer/profile_picture', 'API\CustomerController@change_profile')->middleware('auth:api-customer')->name('customer.change_picture');
    Route::post('customer/logout', 'API\CustomerController@logout')->middleware('auth:api-customer')->name('customer.logout');

    Route::get('customer', 'API\CustomerController@verified_auth')->middleware('auth:api-customer')->name('customer.verified');
    Route::get('customer/{id}', 'API\CustomerController@show')->middleware('auth:api-customer')->name('customer.detail');
    Route::PUT('customer/{id}', 'API\DriverController@update')->middleware('auth:api-customer')->name('customer.update');
    Route::delete('customer/{id}', 'API\DriverController@destroy')->middleware('auth:api-customer')->name('customer.destroy');
});

