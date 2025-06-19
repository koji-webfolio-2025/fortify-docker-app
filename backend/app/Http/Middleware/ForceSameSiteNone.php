<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceSameSiteNone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // すべてのSet-Cookieヘッダーを書き換え
        $headers = $response->headers->getCookies();
        foreach ($headers as $cookie) {
            // SameSite=NoneでSecureなCookieに書き換え
            $response->headers->setCookie(
                new \Symfony\Component\HttpFoundation\Cookie(
                    $cookie->getName(),
                    $cookie->getValue(),
                    $cookie->getExpiresTime(),
                    $cookie->getPath(),
                    $cookie->getDomain(),
                    true, // secure
                    $cookie->isHttpOnly(),
                    false, // raw
                    'None' // SameSite
                )
            );
            Log::info('After', [
                'name' => $cookie->getName(),
                'samesite' => 'None',
            ]);
        }
        return $response;
    }
}
