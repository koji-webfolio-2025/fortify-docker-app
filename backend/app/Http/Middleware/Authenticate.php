<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    public function __construct()
    {
        Log::info('★★Authenticate::__construct★★');
        file_put_contents('/tmp/auth_called.log', date('c') . " called\n", FILE_APPEND);
    }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        Log::info('★★Authenticate::redirectTo★★');
        return null;
    }

    /**
     * Handle unauthenticated users.
     */
    protected function unauthenticated($request, array $guards)
    {
        Log::info('★★Authenticate::unauthenticated★★');
        throw new AuthenticationException('Unauthenticated.', $guards);
    }
}