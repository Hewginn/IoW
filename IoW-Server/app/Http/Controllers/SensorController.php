<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function index(){
        //
    }

    public function show(Sensor $sensor){

        $sensorsMessages = $sensor->messages()->get();
        $detailsHeader = ['Type', 'Status'];
        $details = [$sensor->type, $sensor->status];

        return view('sensors.show', [
            'title' => $sensor->name,
            'details' => $details,
            'detailsHeader' => $detailsHeader,
            'sensorMessages' => $sensorsMessages,
        ]);
    }

    public function store(Request $request){
        //
    }

    public function edit(Sensor $sensor){
        //
    }

    public function update(Request $request, Sensor $sensor){
        //
    }
}
