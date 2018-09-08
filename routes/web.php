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

Route::get('/', 'HomeController@index')->name('home.index');
Route::get('/assets', 'AssetsController@index')->name('assets.index');
Route::get('/asset/{asset}', 'AssetsController@show')->name('assets.show');
Route::get('/markets', 'MarketsController@index')->name('markets.index');
Route::get('/market/{market}', 'MarketsController@show')->name('markets.show');
Route::get('/matches', 'OrderMatchesController@index')->name('matches.index');
Route::get('/orders', 'OrdersController@index')->name('orders.index');
Route::get('/blocks', 'BlocksController@index')->name('blocks.index');
Route::get('/mempool', 'MempoolController@index')->name('mempool.index');
Route::get('/faq', 'PagesController@faq')->name('faq');
Route::get('/disclaimer', 'PagesController@disclaimer')->name('disclaimer');
Route::get('/privacy', 'PagesController@privacy')->name('privacy');
Route::get('/terms', 'PagesController@terms')->name('terms');

Auth::routes();