<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Camera;
use App\Models\DataType;
use App\Models\Image;
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
            'message' => 'Node updated successfully',
            'control' => $request->user()->control,
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
            'message' => 'Sensor details sent successfully',
        ], 200);
    }

    # Adding cameras or updating data of cameras
    public function updateCameras(Request $request)
    {

        # Validating data
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'resolution' => 'required|string',
                'status' => 'required|string',
            ]);
        } catch (ValidationException $e) {

            return response()->json([
                'message' => 'Validation failed',
                'error' => $e->errors(),
            ], 422);
        }

        # Getting node ID
        $node_id = $request->user()->id;

        # Updating data if already exists or creating new data
        if (Camera::where('node_id', $node_id)->where('name', $validated['name'])->exists()) {
            $camera = Camera::where('node_id', $node_id)->where('name', $validated['name'])->first();
            $camera->update($validated);
        } else {
            request()->user()->cameras()->create($validated);
        }

        return response()->json([
            'message' => 'Camera details sent successfully',
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

        try {
            $data_type = DataType::where('data_type', $validated['value_type'])->firstOrFail();
        }catch (ModelNotFoundException $e){
            $data_type = DataType::create([
                'data_type' => $validated['value_type'],
            ]);
        }

        $sensorMessage = SensorMessage::create([
            'sensor_id' => $sensor->id,
            'data_type_id' => $data_type->id,
            'value_type' => $validated['value_type'],
            'value' => $validated['value'],
            'unit' => $validated['unit'],
            'error_message' => $validated['error_message'] ?? null,
        ]);

        return response()->json([
            'message' => 'Sensor data sent successfully',
            'data' => $sensorMessage,
        ], 200);
    }

    public function storeImage(Request $request)
    {

        $node_id = $request->user()->id;

        # Validate the data
        try {
            $validated = $request->validate([
                'camera_name' => [
                    'required',
                    'string',
                    Rule::exists('cameras', 'name')->where('node_id', $node_id),
                ],
                'image' => 'required|image',
                'error_message' => 'nullable|string',
            ]);
        }catch (ValidationException $e){
            return response()->json([
                'message' => 'Validation failed',
            ], 422);
        }

        # Getting camera model
        try {
            $camera = Camera::where('node_id', $node_id)->where('name', $validated['camera_name'])->firstOrFail();
        }catch (ModelNotFoundException $e){
            return response()->json([
                'message' => 'Model not found',
            ], 404);
        }

        # Saving the image
        if ($request->hasFile('image')) {
            $path = 'images/' . $node_id . '/' . $camera->name ;
            $image_path = $request->file('image')->store($path, 'local');
        }else{
            return response()->json([
                'message' => 'Response has no image file.',
            ], 422);
        }

        # Creating image model
        $image = Image::create([
            'camera_id' => $camera->id,
            'path' => $image_path,
            'value' => 0,
            'error_message' => $validated['error_message'] ?? null,
        ]);

        return response()->json([
            'message' => 'Image sent successfully',
        ], 200);
    }
}
