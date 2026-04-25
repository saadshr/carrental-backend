<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;

// ─── AUTH (public) ─────────────────────────────────────
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// ─── VOITURES (public en lecture) ──────────────────────
Route::get('/cars',      [CarController::class, 'index']);
Route::get('/cars/{id}', [CarController::class, 'show']);

// ─── ROUTES PROTÉGÉES (JWT requis) ─────────────────────
Route::middleware('auth:api')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // Dashboard utilisateur
    Route::get('/dashboard', [DashboardController::class, 'userStats']);

    // Réservations utilisateur
    Route::get('/reservations',            [ReservationController::class, 'index']);
    Route::post('/reservations',           [ReservationController::class, 'store']);
    Route::put('/reservations/{id}/cancel',[ReservationController::class, 'cancel']);

    // ─── ADMIN UNIQUEMENT ──────────────────────────────
    Route::middleware('admin')->group(function () {
        // Voitures CRUD
        Route::post('/cars',         [CarController::class, 'store']);
        Route::put('/cars/{id}',     [CarController::class, 'update']);
        Route::delete('/cars/{id}',  [CarController::class, 'destroy']);

        // Réservations admin
        Route::get('/admin/reservations',              [ReservationController::class, 'adminIndex']);
        Route::put('/admin/reservations/{id}/confirm', [ReservationController::class, 'confirm']);

        // Dashboard admin
        Route::get('/admin/dashboard', [DashboardController::class, 'adminStats']);
    });
});