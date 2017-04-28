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

Route::get('/', 'IndexController@index')->name('index');
Route::get('/micelij', 'InitiativeMapController@index')->name('micelij');


Route::get('/bootswatch', function () {
    return view('bootswatch');
});

Route::get('/auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('/auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::auth(); # adds logout etc.

Route::get('/home', 'HomeController@index');

//Auth::routes();

Route::get('/home', 'HomeController@index');
