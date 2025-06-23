<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ヘルスチェック
Route::get('/ping', fn() => response()->json(['pong']));

Route::get('/test-cookie', function () {
    return response('ok')
        ->cookie(
            'test_samesite_none',
            'test_value',
            60,
            '/',
            '.codeshift-lab.com',
            true,   // Secure
            false,  // HttpOnly
            false,  // raw
            'None'  // SameSite
        );
});

Route::get('/', function () {
    return response()->json(['status' => 'ok']);
});