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

Route::get('/markets/{market}/orders', 'Api\MarketOrdersController@index')->name('api.market.orders');
Route::get('/markets/{market}/trades', 'Api\MarketTradesController@index')->name('api.market.trades');