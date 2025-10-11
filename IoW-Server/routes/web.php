<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\NodesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SensorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationsController;

Route::middleware('guest')->controller(AuthController::class)->group(function () {
//    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
//    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/nodes', [NodesController::class, 'index'])->name('nodes.index');
    Route::get('/nodes/create', [NodesController::class, 'create'])->name('nodes.create');
    Route::post('/nodes', [NodesController::class, 'store'])->name('nodes.store');
    Route::get('/nodes/{node}', [NodesController::class, 'show'])->name('nodes.show');

    Route::get('/sensor/{sensor}', [SensorController::class, 'show'])->name('sensors.show');

    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index');
    Route::get('/data', [DataController::class, 'index'])->name('data.index');
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
});

