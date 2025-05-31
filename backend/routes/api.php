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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //return $request->user();
});*/

// ヘルスチェック
Route::get('/ping', fn() => response()->json(['pong']));

// 未認証ユーザーのみ login を許可
//Route::middleware('guest')->post('/login', [AuthenticatedSessionController::class, 'store']);
//Route::middleware(['web', 'guest'])->post('/login', [AuthenticatedSessionController::class, 'store']);

// 認証済みユーザーのみ logout と user を許可
/*Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('/user', fn(Request $request) => $request->user());
});*/