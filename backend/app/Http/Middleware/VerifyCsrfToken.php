<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected function tokensMatch($request)
    {
        file_put_contents('/tmp/csrf_check.txt', "called: ".date('c')."\n", FILE_APPEND);

        \Log::debug('CSRF CHECK', [
            'session_id' => $request->session()->getId(),
            'session_token' => $request->session()->token(),
            'header_token' => $request->header('X-XSRF-TOKEN'),
            'input_token' => $request->input('_token'),
            'cookies' => $_COOKIE,
            'all_headers' => $request->headers->all()
        ]);
        // これより下はそのまま
        $token = $this->getTokenFromRequest($request);
        return is_string($request->session()->token()) &&
            is_string($token) &&
            hash_equals($request->session()->token(), $token);
    }
}
