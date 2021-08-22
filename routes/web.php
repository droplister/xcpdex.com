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

Route::get('/', 'MarketsController@index')->name('home.index');
Route::get('/locale/{locale}', 'LocaleController@show')->name('locale.show');
Route::get('/address/{address}', 'AddressesController@show')->name('addresses.show');
Route::get('/assets', 'AssetsController@index')->name('assets.index');
Route::get('/asset/{asset}', 'AssetsController@show')->name('assets.show');
Route::get('/markets/{quote_asset?}', 'MarketsController@index')->name('markets.index');
Route::get('/market/{market}', 'MarketsController@show')->name('markets.show');
Route::get('/trades', 'OrderMatchesController@index')->name('matches.index');
Route::get('/matches', 'OrderMatchesController@redirect')->name('matches.redirect');
Route::get('/orders', 'OrdersController@index')->name('orders.index');
Route::get('/blocks', 'BlocksController@index')->name('blocks.index');
Route::get('/block/{block}', 'BlocksController@show')->name('blocks.show');
Route::get('/mempool', 'MempoolController@index')->name('mempool.index');
Route::get('/disclaimer', 'PagesController@disclaimer')->name('pages.disclaimer');
Route::get('/privacy', 'PagesController@privacy')->name('pages.privacy');
Route::get('/stats', 'PagesController@stats')->name('pages.stats');
Route::get('/terms', 'PagesController@terms')->name('pages.terms');
Route::get('/{asset}', 'AssetsController@show');