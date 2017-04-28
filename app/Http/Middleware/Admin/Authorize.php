<?php

namespace App\Http\Middleware\Admin;

use Auth;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class Authorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string $group
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle($request, Closure $next, $group)
    {
        if(Auth::guest() or !Auth::user()->can('manage ' . $group)){
            throw new AuthorizationException(trans('backpack::base.unauthorized'));
        }

        return $next($request);
    }
}
