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
    return redirect('login');
});

Auth::routes();

Route::group(['middleware' => 'auth','prefix' => 'admin','as' => 'admin.'], function(){
    Route::get('dashboard','DashboardController@index')->name('dashboard.index');
    Route::get('user/profile','UserController@profile')->name('user.profile');
    Route::post('user/profile','UserController@setProfile')->name('user.profile.update');
    Route::resources([
        'lpj' => 'LPJController',
        'rekening' => 'RekeningController',
        'user' => 'UserController',
        'satuan-kerja' => 'SatuanKerjaController',
        'spm' => 'SPMController',
        'transaksi' => 'TransaksiController',
        'spm-admin' => 'SPMAdminController',
        'rekonsiliasi' => 'RekonsiliasiController'
    ]);
});