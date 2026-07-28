<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasTenant
{

    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()?->tenant_id) {
            return response()->json(['message' => 'Tenant access required.'], 403);
        }

        return $next($request);
    }
}