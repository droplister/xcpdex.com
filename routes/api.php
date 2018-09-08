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

Route::get('/search', 'Api\MarketSearchController@index')->name('api.search');
Route::get('/markets/{market}/chart', 'Api\MarketChartController@index')->name('api.market.chart');
Route::get('/markets/{market}/depth', 'Api\MarketDepthController@index')->name('api.market.depth');
Route::get('/markets/{market}/orders', 'Api\MarketOrdersController@index')->name('api.market.orders');
Route::get('/markets/{market}/order-matches', 'Api\MarketOrderMatchesController@index')->name('api.market.orderMatches');