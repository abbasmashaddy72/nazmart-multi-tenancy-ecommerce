<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('admin-home') || $request->is('admin-home/*')){
                if (!is_null(tenant())){
                    return route('tenant.admin.login');
                }
                return route('landlord.admin.login');
            }
            if ($request->is('user-home') || $request->is('user-home/*')){
                return route('tenant.user.login');
            }
        }
    }
}
