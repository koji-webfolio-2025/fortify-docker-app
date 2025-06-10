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
