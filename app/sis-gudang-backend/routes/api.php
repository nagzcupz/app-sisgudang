<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\MutasiController;

Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('barangs', BarangController::class);
    Route::apiResource('mutasis', MutasiController::class);
    Route::get('barangs/{barangId}/mutasis', [MutasiController::class, 'showMutationByItem']);
    Route::get('users/{userId}/mutasis', [MutasiController::class, 'showMutationByUser']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', function (Request $request) {
        return $request->user();
    })->name('user');
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
