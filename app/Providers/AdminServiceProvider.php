<?php

namespace App\Providers;

use App\Http\Middleware\Admin;
use CRUD;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Route;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /** @var Router $router */
        $router = $this->app->router;
        $router->middleware('admin', Admin::class);
        $router->middleware('authorize', Admin\Authorize::class);

        $router->group(['prefix' => config('backpack.base.route_prefix', 'admin'), 'middleware' => ['web', 'admin'], 'laroute' => false],
            function (Router $router) {
                /**
                 * Initiatives, categories, audiences
                 */
                $router->group(['namespace' => 'App\Http\Controllers\Admin\Initiative', 'middleware' => 'authorize:initiatives'], function () {
                    CRUD::resource('category', 'CategoryCrudController');
                    CRUD::resource('audience', 'AudienceCrudController');
                    CRUD::resource('initiative', 'InitiativeCrudController');
                });

                /**
                 * Events
                 */
                $router->group(['namespace' => 'App\Http\Controllers\Admin', 'middleware' => 'authorize:events'], function () {
                    CRUD::resource('event', 'EventCrudController');
                });

                /**
                 * Pages
                 */
                $router->group(['namespace' => 'Backpack\PageManager\app\Http\Controllers', 'middleware' => 'authorize:pages'], function (Router $router) {
                    // Backpack\PageManager routes
                    Route::get('page/create/{template}', 'Admin\PageCrudController@create');
                    Route::get('page/{id}/edit/{template}', 'Admin\PageCrudController@edit');

                    // This triggered an error before publishing the PageTemplates trait, when calling Route::controller();
                    // CRUD::resource('page', 'Admin\PageCrudController');

                    // So for PageCrudController all routes are explicitly defined:
                    Route::get('page/reorder', 'Admin\PageCrudController@reorder');
                    Route::get('page/reorder/{lang}', 'Admin\PageCrudController@reorder');
                    Route::post('page/reorder', 'Admin\PageCrudController@saveReorder');
                    Route::post('page/reorder/{lang}', 'Admin\PageCrudController@saveReorder');
                    Route::get('page/{id}/details', 'Admin\PageCrudController@showDetailsRow');
                    Route::get('page/{id}/translate/{lang}', 'Admin\PageCrudController@translateItem');
                    Route::resource('page', 'Admin\PageCrudController');
                });

                /**
                 * Users
                 */
                $router->group(['namespace' => 'Backpack\PermissionManager\app\Http\Controllers', 'middleware' => 'authorize:users'], function () {
                    CRUD::resource('permission', 'PermissionCrudController');
                    CRUD::resource('role', 'RoleCrudController');
                    CRUD::resource('user', 'UserCrudController');
                });

                /**
                 * Menu
                 */
                $router->group(['namespace' => 'Backpack\MenuCRUD\app\Http\Controllers\Admin', 'middleware' => 'authorize:menu'], function () {
                    CRUD::resource('menu-item', 'MenuItemCrudController');
                });

                /**
                 * Languages
                 */
                $router->group(['namespace' => 'Backpack\LangFileManager\app\Http\Controllers', 'middleware' => 'authorize:translations'], function () {
                    Route::get('language/texts/{lang?}/{file?}', 'LanguageCrudController@showTexts');
                    Route::post('language/texts/{lang}/{file}', 'LanguageCrudController@updateTexts');
                    Route::resource('language', 'LanguageCrudController');
                });

                /**
                 * Settings
                 */
                $router->group(['namespace' => 'Backpack\Settings\app\Http\Controllers', 'middleware' => 'authorize:settings'], function () {
                    Route::resource('setting', 'SettingCrudController');
                });

                /**
                 * Backups
                 */
                $router->group(['namespace' => 'Backpack\BackupManager\app\Http\Controllers', 'middleware' => 'authorize:backups'], function () {
                    Route::get('backup', 'BackupController@index');
                    Route::put('backup/create', 'BackupController@create');
                    Route::get('backup/download/{file_name?}', 'BackupController@download');
                    Route::delete('backup/delete/{file_name?}', 'BackupController@delete');
                });
            }
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->singleton('admin', Admin::class); # not really needed afaik
    }
}
