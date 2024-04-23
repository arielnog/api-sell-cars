<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;

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

Route::get('/health', [HealthController::class, 'index']);

Route::middleware(['validate.key'])->group(function () {
    Route::prefix('announcements')->group(function () {
        Route::get('/', [AnnouncementController::class, 'getList']);
        Route::post('/simulation/{announcementId}', [AnnouncementController::class, 'calculateSimulation']);
    });
});
