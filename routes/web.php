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
    Route::get('transaksi/print','TransaksiController@print')->name('transaksi.print');
    Route::resources([       
        'user' => 'UserController',
        'bahan-baku' => 'BahanBakuController',    
        'barang' => 'BarangController',    
        'pelanggan' => 'PelangganController', 
        'produksi' => 'ProduksiController', 
        'transaksi' => 'TransaksiController'
    ]);

    Route::get('produksi/{id}/bahan-baku','ProduksiController@createBahanBaku')->name('produksi.create.bahan-baku');
    Route::post('produksi/{id}/bahan-baku','ProduksiController@storeBahanBaku')->name('produksi.store.bahan-baku');
    Route::get('produksi/{id}/delete','ProduksiController@deleteBahanBaku')->name('produksi.delete.bahan-baku');
   
    
});