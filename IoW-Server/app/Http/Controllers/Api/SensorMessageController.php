<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SensorMessageRequest;
use App\Models\Sensor;
use App\Models\SensorMessage;
use Illuminate\Http\Request;

class SensorMessageController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(SensorMessageRequest $request)
    {
        $data=[
            'sensor_id' => $request->sensor_id,
            'value' => $request->value,
            'error_message' => $request->error_message,
            'value_type' => $request->value_type,
        ];

        $sensor_message = SensorMessage::create($data);

        return response()->json([
            'message' => 'Data received successfully',
            'data' => $data,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
