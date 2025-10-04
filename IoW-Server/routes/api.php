<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorMessageController;

Route::post('/send_data', [SensorMessageController::class, 'store']);
