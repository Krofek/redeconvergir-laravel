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

Route::get('/', function () {
    return view('welcome');
})->middleware('auth:api');
/*
 * zgoraj lahko tudi...
Route::get('/', 'IndexController@index');
Route::get('/initiatives', 'InitiativeController@index');
 */


Route::auth();
Route::get('/auth/{provider}', 'Auth\AuthController@redirectToProvider')->name('auth.provider');
Route::get('/auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback')->name('auth.provider.callback');

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth'], function() {

    // Initiative
    Route::group(['prefix' => 'initiative'], function() {
        Route::get('/', 'InitiativeController@index')->name('initiative.index');
        Route::get('/create', 'InitiativeController@create')->name('initiative.create');
        Route::match(['GET', 'POST'], '/', 'InitiativeController@store')->name('initiative.store');

        Route::get('/{initiative}', 'InitiativeController@find')->name('initiative.show');
    });
});
