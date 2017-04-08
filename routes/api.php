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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['as' => 'api::', 'middleware' => 'api', 'namespace' => 'Api'], function (){
    Route::get('map/filters-data', ['as' => 'initiative-filters-data', 'uses' => 'MapController@filtersData']); # called on init, fetches filter data

    Route::get('map/markers', ['as' => 'map-markers', 'uses' => 'MapController@markers']); # called on filters change
    Route::get('map/initiatives', ['as' => 'initiatives', 'uses' => 'MapController@initiatives']); # called on boundsChange
});