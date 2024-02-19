<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetricHistoryRunController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('services/get_metrics', [MetricHistoryRunController::class, 'getMetrics'])->name('metric.get_metrics');
Route::post('services/save_metrics', [MetricHistoryRunController::class, 'create'])->name('metric.save_metrics');
Route::apiResource('services/get_history', MetricHistoryRunController::class);