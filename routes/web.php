<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetricHistoryRunController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'metric',
], function () {
    Route::get('/run', [MetricHistoryRunController::class, 'run'])->name('metric.run');
    Route::get('/history', [MetricHistoryRunController::class, 'history'])->name('metric.history');
});