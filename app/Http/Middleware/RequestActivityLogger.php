<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class RequestActivityLogger
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            // Log only authenticated accesses to important routes
            if (Auth::check()) {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'action' => 'access',
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'route' => optional($request->route())->getName() ?? $request->path(),
                    'method' => $request->method(),
                    'meta' => [
                        'params' => $request->except(['password','_token']),
                    ],
                ]);
            }
        } catch (\Throwable $e) {
            // swallow logging errors
        }

        return $response;
    }
}
