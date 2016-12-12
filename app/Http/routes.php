<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
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
   Route::post('initiatives', ['as' => 'initiatives', 'uses' => 'InitiativeController@index']);
});

Route::get('/auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('/auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

Route::auth(); # adds logout etc.

Route::get('/home', 'HomeController@index');
