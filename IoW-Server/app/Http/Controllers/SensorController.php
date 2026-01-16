<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\SensorMessage;
use Illuminate\Http\Request;

class SensorController extends Controller
{

    # Show the measurements of a sensor
    public function show(Sensor $sensor){

        $sensorsMessages = $sensor->messages()->orderBy('created_at', 'desc')->paginate(10);
        $detailsHeader = ['Type', 'Status', 'Node'];
        $details = [$sensor->type, $sensor->status, $sensor->node->name];

        return view('sensors.show', [
            'title' => $sensor->name,
            'details' => $details,
            'node' => $sensor->node,
            'detailsHeader' => $detailsHeader,
            'sensorMessages' => $sensorsMessages,
        ]);
    }

    public function destroy(SensorMessage $sensorMessage)
    {
        $sensorMessage->delete();
        return back()->with('success', 'Sensor message deleted!');
    }
}
