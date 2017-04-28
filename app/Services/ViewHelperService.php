<?php
namespace App\Services;
use Route;

class ViewHelperService
{
    public static function showWideNavbar()
    {
        return in_array(Route::current()->getName(), config('website.view.wide_navbar_route_names'));
    }
}