<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorMessageController;

Route::middleware('auth::sanctum')->post('/send_data', [SensorMessageController::class, 'store']);
