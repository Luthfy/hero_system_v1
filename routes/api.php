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

    /* MERCHANT */
    Route::post('merchant', 'API\MerchantController@login')->name('merchant.login');
    Route::post('merchant/register', 'API\MerchantController@store')->name('merchant.register');
    Route::post('merchant/otp', 'API\MerchantController@activated_by_otp')->middleware('auth:api-merchant')->name('merchant.otp');
    Route::post('merchant/logout', 'API\MerchantController@logout')->middleware('auth:api-merchant')->name('merchant.logout');
    Route::post('merchant/dokumen_kelengkapan', 'API\MerchantController@upload_document')->middleware('auth:api-merchant')->name('merchant.dokumen');


    Route::get('merchant', 'API\MerchantController@verified_auth')->middleware('auth:api-merchant');
    Route::get('merchant/{id}', 'API\MerchantController@show')->middleware('auth:api-merchant')->name('merchant.detail');

    Route::put('merchant/{id}', 'API\MerchantController@update')->middleware('auth:api-merchant')->name('merchant.update');

    Route::delete('merchant/{id}', 'API\MerchantController@destroy')->middleware('auth:api-merchant')->name('merchant.destroy');

    /* END MERCHANT */

    /* PPOB */
    Route::post('ppob/test_connection', 'API\PPOBController@test_connection')->middleware('auth:api-customer');
    Route::post('ppob/check_saldo', 'API\PPOBController@check_saldo')->middleware('auth:api-customer');

    Route::post('ppob/pembayaran/kategori', 'API\PPOBController@pembayaran_kategori')->middleware('auth:api-customer');
    Route::post('ppob/pembayaran/operator', 'API\PPOBController@pembayaran_operator')->middleware('auth:api-customer');
    Route::post('ppob/pembayaran/produk', 'API\PPOBController@pembayaran_produk')->middleware('auth:api-customer');
    Route::post('ppob/pembayaran/detail', 'API\PPOBController@pembayaran_detail')->middleware('auth:api-customer');

    Route::post('ppob/pembelian/kategori', 'API\PPOBController@pembelian_kategori')->middleware('auth:api-customer');
    Route::post('ppob/pembelian/operator', 'API\PPOBController@pembelian_operator')->middleware('auth:api-customer');
    Route::post('ppob/pembelian/produk', 'API\PPOBController@pembelian_produk')->middleware('auth:api-customer');
    Route::post('ppob/pembelian/detail', 'API\PPOBController@pembelian_detail')->middleware('auth:api-customer');

});

