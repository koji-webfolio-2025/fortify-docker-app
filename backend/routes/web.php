<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::middleware(['web', 'guest'])->post('/login', [AuthenticatedSessionController::class, 'store']);
Route::middleware(['web', 'auth'])->post('/logout', [AuthenticatedSessionController::class, 'destroy']);

// ↓API用ユーザー情報
Route::middleware(['web', 'auth'])->get('/api/user', function (Request $request) {
    return response()->json([
        'cookie'  => $request->cookies->all(),
        'session' => session()->all(),
        'user'    => auth()->user(),
    ]);
});

Route::post('/test-post', function(Request $req) {
    return response()->json(['ok' => true, 'all' => $req->all()]);
});

Route::get('/test-cookie', function () {
    return response('ok')
        ->cookie(
            'test_samesite_none',
            'test_value',
            60, // 分
            '/',
            '.codeshift-lab.com',
            true,   // Secure
            false,  // HttpOnly
            false,  // raw
            'None'  // SameSite
        );
});