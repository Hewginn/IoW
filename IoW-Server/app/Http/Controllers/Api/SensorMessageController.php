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

        $validated = $request->validated();

        $sensor_message = SensorMessage::create($validated);

        return response()->json([
            'message' => 'Data received successfully',
            'data' => $validated,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
