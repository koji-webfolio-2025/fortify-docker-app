<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::middleware('auth')->get('/user', function (Request $request) {
    return response()->json([
        'cookie'  => $request->cookie(),
        'session' => session()->all(),
        'user'    => auth()->user(),
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ヘルスチェック
Route::get('/ping', fn() => response()->json(['pong']));