<?php

use Illuminate\Http\Request;

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
Route::get('/mempool', 'Api\MempoolController@index')->name('api.mempool');
Route::get('/blocks', 'Api\BlocksController@index')->name('api.blocks');
Route::get('/orders', 'Api\OrdersController@index')->name('api.orders');
Route::get('/orders/chart', 'Api\OrdersController@chart')->name('api.orders.chart');
Route::get('/orders/{address}', 'Api\OrdersController@address')->name('api.orders.address');
Route::get('/order-matches', 'Api\OrderMatchesController@index')->name('api.orderMatches');
Route::get('/order-matches/chart', 'Api\OrderMatchesController@chart')->name('api.orderMatches.chart');
Route::get('/markets', 'Api\MarketsController@index')->name('api.markets');
Route::get('/markets/search', 'Api\MarketSearchController@index')->name('api.market.search');
Route::get('/markets/{market}/chart', 'Api\MarketChartController@index')->name('api.market.chart');
Route::get('/markets/{market}/depth', 'Api\MarketDepthController@index')->name('api.market.depth');
Route::get('/markets/{market}/orders', 'Api\MarketOrdersController@index')->name('api.market.orders');
Route::get('/markets/{market}/order-matches', 'Api\MarketOrderMatchesController@index')->name('api.market.orderMatches');