<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\CharChecker;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WarehouseController;

Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware('web');
    Route::post('/register', [AuthController::class, 'register'])->withoutMiddleware('web');
    // Route::middleware(['auth:sanctum', RoleMiddleware::class])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->withoutMiddleware('web');
    // });
});

Route::prefix('asset')->group(function() {
    // Route::middleware(['auth:sanctum', RoleMiddleware::class])->group(function () {
        Route::get('/all', [AssetController::class, 'get_all_assets'])->withoutMiddleware('web');
        Route::post('/detail', [AssetController::class, 'get_by_id'])->withoutMiddleware('web');
        Route::post('/create', [AssetController::class, 'create'])->withoutMiddleware('web');
        Route::post('/edit', [AssetController::class, 'update'])->withoutMiddleware('web');
        Route::delete('/delete', [AssetController::class, 'delete'])->withoutMiddleware('web');
    // });
});

Route::prefix('warehouse')->group(function() {
    // Route::middleware(['auth:sanctum', RoleMiddleware::class])->group(function () {
        Route::get('/all', [WarehouseController::class, 'get_all_warehouses'])->withoutMiddleware('web');
        Route::post('/detail', [WarehouseController::class, 'get_by_id'])->withoutMiddleware('web');
        Route::post('/create', [WarehouseController::class, 'create'])->withoutMiddleware('web');
        Route::post('/edit', [WarehouseController::class, 'update'])->withoutMiddleware('web');
        Route::delete('/delete', [WarehouseController::class, 'delete'])->withoutMiddleware('web');
    // });
});

Route::prefix('char-checker')->group(function () {
    // Route::middleware(['auth:sanctum', RoleMiddleware::class])->group(function () {
        Route::post('/validate', [CharChecker::class, 'validate'])->withoutMiddleware('web');
    // });
});