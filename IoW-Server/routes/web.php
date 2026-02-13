<?php

use App\Http\Controllers\CameraController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\ImageController;
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
    Route::get('/changeControl', [NodesController::class, 'changeControl'])->name('nodes.changeControl');
    Route::delete('/nodes/{node}/destroy', [NodesController::class, 'destroy'])->name('nodes.destroy');
    Route::get('/nodes/{node}', [NodesController::class, 'show'])->name('nodes.show');

    Route::get('/sensor/{sensor}', [SensorController::class, 'show'])->name('sensors.show');
    Route::delete('/deleteSensorMessage/{sensorMessage}', [SensorController::class, 'destroy'])->name('sensorMessage.destroy');

    Route::get('/camera/{camera}', [CameraController::class, 'show'])->name('cameras.show');
    Route::get('/camera-image/{path}', [ImageController::class, 'show'])->where('path', '.*');
    Route::get('/images', [ImageController::class, 'index'])->name('images.index');
    Route::get('/images/{image}/vision', [ImageController::class, 'vision'])->name('images.vision');
    Route::delete('/images/{image}', [ImageController::class, 'destroy'])->name('images.destroy');

    Route::get('/data', [DataController::class, 'index'])->name('data.index');
    Route::get('/data/{data_type}', [DataController::class, 'show'])->name('data.show');

    Route::get('/', [HomeController::class, 'index'])->name('home.index');
});

