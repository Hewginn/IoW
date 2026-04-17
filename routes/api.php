<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/nodeLogin', [ApiController::class, 'nodeLogin']);

Route::middleware('auth:sanctum')->group(function (){
    Route::post('/sendData', [ApiController::class, 'storeSensorMessage']);
    Route::post('/updateNode', [ApiController::class, 'updateNode']);
    Route::post('/updateSensors', [ApiController::class, 'updateSensors']);
    Route::post('/sendImage', [ApiController::class, 'storeImage']);
    Route::post('/updateCameras', [ApiController::class, 'updateCameras']);
});
