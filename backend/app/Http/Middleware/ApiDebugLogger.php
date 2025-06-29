<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class ApiDebugLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        \Log::info('API_HEADERS', [
            'url'    => $request->fullUrl(),
            'cookie' => $request->header('cookie'),
            'origin' => $request->header('origin'),
            'referer'=> $request->header('referer'),
            'all'    => $request->headers->all(),
        ]);
        return $next($request);
    }
}
