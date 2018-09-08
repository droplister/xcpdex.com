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

Route::get('/assets', 'AssetsController@index')->name('assets.index');
Route::get('/asset/{asset}', 'AssetsController@show')->name('assets.show');
Route::get('/markets', 'MarketsController@index')->name('markets.index');
Route::get('/market/{market}', 'MarketsController@show')->name('markets.show');
Route::get('/trades', 'TradesController@index')->name('trades.index');
Route::get('/orders', 'OrdersController@index')->name('orders.index');
Route::get('/blocks', 'BlocksController@index')->name('blocks.index');
Route::get('/mempool', 'MempoolController@index')->name('mempool.index');

Auth::routes();