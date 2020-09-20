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
Route::get('v1/puzzle', 'API\v1\PuzzleController@index');

Route::prefix('v1/players')->group(function() {
    Route::post('/', 'API\v1\PlayerController@store');
    Route::get('/', 'API\v1\PlayerController@index');
    Route::get('/{id_players}', 'API\v1\PlayerController@index');
    Route::post('/add-ball', 'API\v1\PlayerController@storeBall');
});

Route::prefix('v1/containers')->group(function() {
    Route::post('/', 'API\v1\ContainerController@store');
    Route::get('/', 'API\v1\ContainerController@index');
    Route::get('/{id}', 'API\v1\ContainerController@index');
});

Route::prefix('v1/orders')->group(function() {
    Route::post('/', 'API\v1\OrderController@store');
    Route::get('/{order_code}', 'API\v1\OrderController@index');
    Route::put('/{id}', 'API\v1\OrderController@update');
    Route::delete('/{id}', 'API\v1\OrderController@destroy');
    Route::post('/checkout/{code_histories}', 'API\v1\OrderController@checkout');
});
