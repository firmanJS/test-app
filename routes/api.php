<?php

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
Route::get('v1/', 'API\v1\IndexController@index');

Route::prefix('v1/orders')->group(function() {
    Route::post('/', 'API\v1\OrderController@store');
    Route::get('/{order_code}', 'API\v1\OrderController@index');
    Route::put('/{id}', 'API\v1\OrderController@update');
    Route::delete('/{id}', 'API\v1\OrderController@destroy');
    Route::post('/checkout/{code_histories}', 'API\v1\OrderController@checkout');
});
