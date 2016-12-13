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

/**
 * Note: admin routes accessible in AdminServiceProvider
 */

Route::get('/', 'IndexController@index');
Route::get('/micelij', 'InitiativeMapController@index');


Route::get('/bootswatch', function () {
    return view('bootswatch');
});

Route::group(['prefix' => 'api', 'as' => 'api::', 'middleware' => 'api', 'namespace' => 'Api'], function (){
    Route::post('initiatives/markers', ['as' => 'initiatives-markers', 'uses' => 'InitiativeController@markers']); # called on filters change
    Route::post('initiatives/list-items', ['as' => 'initiatives-list-items', 'uses' => 'InitiativeController@listItems']); # called on boundsChange
});

Route::get('/auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('/auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

Route::auth(); # adds logout etc.

Route::get('/home', 'HomeController@index');
