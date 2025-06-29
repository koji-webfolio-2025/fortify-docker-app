<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/user', function (Request $request) {
        \Log::info('API_HEADERS', ['user' => $request->user()]);
        return $request->user();
    });
    Route::get('/memos', [\App\Http\Controllers\MemoController::class, 'index']);
    Route::post('/memos', [\App\Http\Controllers\MemoController::class, 'store']);
});

Route::get('/test-log', function () {
    \Log::info('★★TEST LOG ROUTE HIT★★');
    return ['ok'];
});