<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('request', '\App\Http\Controllers\API\RequestController@index')->name('request.api');

Route::middleware('auth.api')->group(function () {
    Route::get('warehouse', '\App\Http\Controllers\API\WarehouseController@index')->name('warehouse.api');
    Route::get('item', '\App\Http\Controllers\API\ItemController@index')->name('item_all.api');
    Route::get('item/{id}', '\App\Http\Controllers\API\ItemController@show')->name('item.api');
    Route::get('stock/{id}', '\App\Http\Controllers\API\StockController@show')->name('stock.api');
});