<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function() {
    return view('home');
})->middleware('auth');

Auth::routes([
    "register" => FALSE,
    "reset" => FALSE,
    "verify" => FALSE
]);

Route::get('/home', 'HomeController@index')->name('home');

// ROUTE MEMBERS
Route::get('/members', 'Web\MemberController@index')->name('member');

// Route CUSTOMERS
Route::get('/customers', 'Web\CustomerController@index')->name('customer');

// Route DRIVERS
Route::get('/drivers', 'Web\DriverController@index')->name('driver');

// Route MERCHANTS
Route::get('/merchants', 'Web\MerchantController@index')->name('merchant');

// Route MERCHANTS
Route::get('/wallets', 'Web\WalletController@index')->name('wallet');

// Route VERSION
Route::get('/version_setting', 'Web\VersionController@index')->name('version_setting');

// ROUTE AFFILIATE
Route::group(['prefix' => 'affiliate'], function () {
    Route::get('levelmember', 'Web\LevelMemberController@index')->name('levelmember');
    Route::get('levelmember/create', 'Web\LevelMemberController@create')->name('levelmember.create');
    Route::post('levelmember', 'Web\LevelMemberController@store')->name('levelmember.store');
});
