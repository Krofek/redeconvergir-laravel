<?php
/**
 * Created by PhpStorm.
 * User: krofek
 * Date: 7/14/16
 * Time: 1:14 AM
 */

Route::group(['middleware' => ['api', 'cors'], 'prefix' => 'api'], function () {

    Route::group(['prefix' => config('rede_api.version')], function () {
        // authentication
        Route::post('register', 'APIController@register');
        Route::post('login', 'APIController@login');

        Route::group(['middleware' => 'auth:api'], function () {

            //

        });
    });

});