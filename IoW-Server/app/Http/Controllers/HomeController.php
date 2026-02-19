<?php

namespace App\Http\Controllers;

use App\Models\DataType;
use App\Models\Image;
use App\Models\SensorMessage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $data_types = DataType::query()->get();

        $latest_values = [];

        $return_data_types = [];

        $image = Image::query()->with('camera')->latest()->first();

        foreach ($data_types as $data_type) {

            $message = $data_type->messages()->whereNull('error_message')->latest()->first();

            if($message){
                $latest_values[$data_type->id] = $message;
                $return_data_types[$data_type->id] = $data_type;
            }
        }

        return view('home.index', [
            'title' => 'Home',
            'data_types' => $return_data_types,
            'latest_values' => $latest_values,
            'image' => $image,
        ]);
    }
}
