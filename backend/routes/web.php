<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
//Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth');

Route::middleware('auth')->get('/api/user', function (Request $request) {
    return response()->json([
        'cookie'  => $request->cookies->all(),
        'session' => session()->all(),
        'user'    => auth()->user(),
    ]);
});