<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SensorMessageRequest;
use App\Models\Node;
use App\Models\Sensor;
use App\Models\SensorMessage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Nette\Schema\ValidationException;

class ApiController extends Controller
{
    public function nodeLogin (Request $request){

        $validated = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $node = Node::where('name', $validated['name'])->first();

        if(!$node || !Hash::check($validated['password'], $node->password)){
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $node->createToken($validated['name'] . '-token')->plainTextToken;

        return response()->json([
            'message' => 'Logged in successfully',
            'token' => $token,
        ], 200);
    }

    public function updateNode(Request $request){

        try {

            $validated = $request->validate([
                'location' => 'required|string',
                'status' => 'required|string',
                'main_unit' => 'required|string',
            ]);

        }catch (ValidationException $e){

            return response()->json([
                'message' => 'Validation failed',
            ], 422);
        }

        $request->user()->update($validated);

        return response()->json([
            'message' => 'Updated successfully',
        ], 200);
    }

    public function updateSensors(Request $request){

        try{
            $validated = $request->validate([
                'name' => 'required|string',
                'status' => 'required|string',
                'type' => 'required|string',
            ]);
        }catch (ValidationException $e){

            return response()->json([
                'message' => 'Validation failed',
                'error' => $e->errors(),
            ], 422);
        }

        $node_id = $request->user()->id;
        if(Sensor::where('node_id', $node_id)->where('name', $validated['name'])->exists()){
            $sensor = Sensor::where('node_id', $node_id)->where('name', $validated['name'])->first();
            $sensor->update($validated);
        }else{
            request()->user()->sensors()->create($validated);
        }

        return response()->json([
            'message' => 'Data sent successfully',
        ], 200);
    }

    public function storeSensorMessage(Request $request)
    {

        try {
            $validated = $request->validate([
                'sensor_name' => 'required|string',
                'value_type' => 'required|string',
                'value' => 'required|numeric',
                'unit' => 'required|string',
                'error_message' => 'nullable|string',
            ]);
        }catch (ValidationException $e){
            return response()->json([
                'message' => 'Validation failed',
            ], 422);
        }

        $node_id = $request->user()->id;

        try {
            $sensor = Sensor::where('node_id', $node_id)->where('name', $validated['sensor_name'])->firstOrFail();
        }catch (ModelNotFoundException $e){
            return response()->json([
                'message' => 'Model not found',
            ], 404);
        }

        $sensorMessage = SensorMessage::create([
            'sensor_id' => $sensor->id,
            'value_type' => $validated['value_type'],
            'value' => $validated['value'],
            'unit' => $validated['unit'],
            'error_message' => $validated['error_message'],
        ]);

        return response()->json([
            'message' => 'Data sent successfully',
            'data' => $sensorMessage,
        ], 200);
    }
}
