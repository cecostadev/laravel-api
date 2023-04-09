<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!$request->user()->hasPermissionTo($permission)) {
            return abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}