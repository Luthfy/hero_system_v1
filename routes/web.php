<?php

use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function() {
//     return view('home');
// })->middleware('auth');

Auth::routes([
    "register" => FALSE,
    "reset" => FALSE,
    "verify" => FALSE
]);

Route::get('/home', 'HomeController@index')->name('home');

// ROUTE MEMBERS
Route::resource('members', 'Web\MemberController');

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
    Route::resource('levelmember', 'Web\LevelMemberController');
    Route::resource('medalmember', 'Web\MedalMemberController');
    Route::resource('bonusgenerasi', 'Web\BonusGenerasiController');
    Route::resource('batasanpenarikan', 'Web\BatasanPenarikanController');
    Route::resource('komisitransaksi', 'Web\KomisiTransaksiController');
});
