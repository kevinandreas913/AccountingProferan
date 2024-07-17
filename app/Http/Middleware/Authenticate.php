<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // return $request->expectsJson() ? null : route('auth.login.view');
        if($request->expectsJson()) {
            return null;
        }
        
        if($request->is('admin/*')) {
            return route('auth.admin.login.view');
        } else {
            return route('auth.login.view');
        }
    }
}
