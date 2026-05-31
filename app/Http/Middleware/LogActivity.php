<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Log only POST, PUT, PATCH, DELETE requests
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => strtolower($request->method()) . '_' . str_replace('/', '_', $request->path()),
                'model_type' => null,
                'model_id' => null,
                'description' => $request->method() . ' request to ' . $request->path(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'old_values' => null,
                'new_values' => $request->except(['password', 'password_confirmation']),
            ]);
        }

        return $response;
    }
}
