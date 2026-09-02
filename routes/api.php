<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\TerbilangController;
use App\Http\Controllers\BintangController;
use App\Http\Controllers\SalaryLevelController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('karyawan', KaryawanController::class);
    Route::get('/salary-level', [SalaryLevelController::class, 'index']);

    Route::post('/terbilang', [TerbilangController::class, 'convert']);
    Route::get('/terbilang/history', [TerbilangController::class, 'history']);

    Route::post('/bintang', [BintangController::class, 'generate']);
    Route::get('/bintang/history', [BintangController::class, 'history']);

});