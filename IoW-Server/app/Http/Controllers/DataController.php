<?php

namespace App\Http\Controllers;

use App\Models\DataType;
use App\Models\Image;
use App\Models\SensorMessage;
use Illuminate\Http\Request;

class DataController extends Controller
{

    // Returning index page for all data types
    public function index(){
        $data_types = DataType::query()->get();

        return view('data.index', [
            'title' => 'Data',
            'data_types' => $data_types,
        ]);
    }

    // Returning all data from one data type (example return all temperature data)
    public function show(DataType $data_type){

        // Get data for simple record plotting
        $data = $data_type->messages()->orderBy('created_at', 'desc')->paginate(10);

        // Checking if is ther any data
        if($data->isEmpty()){
            return view('data.show', [
                'title' => ucfirst($data_type->data_type),
                'data_type' => $data_type,
                'datas' => $data,
                'data_exists' => false
            ]);
        }

        // Get data for making chart
        $chart_data = $data_type->messages()->whereNull('error_message')->orderBy('created_at', 'asc')->get();

        // Checking if making a chart is possible
        if($chart_data->isEmpty()){
            return view('data.show', [
                'title' => ucfirst($data_type->data_type),
                'data_type' => $data_type,
                'datas' => $data,
                'data_exists' => false,
                'able_to_chart' => false
            ]);
        }

        // Getting the values for the chart
        $labels = $chart_data->pluck('created_at')->map->format('Y-m-d H:i')->toArray();
        $values = $chart_data->pluck('value')->toArray();
        $chart_name = $data_type->data_type . " (" . $data_type->unit . ")";


        return view('data.show', [
            'title' => ucfirst($data_type->data_type),
            'data_type' => $data_type,
            'datas' => $data,
            'labels' => $labels,
            'values' => $values,
            'chart_name' => $chart_name,
            'data_exists' => true,
            'able_to_chart' => true
        ]);
    }

    // Delete all sensor messages and images from one date until another
    public function destroy(Request $request)
    {
        // Validate inputs
        $request->validate([
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        // Convert to full timestamps
        $start = $request->start_date . ' 00:00:00';
        $end   = $request->end_date . ' 23:59:59';

        // Delete records in the range
        SensorMessage::whereBetween('created_at', [$start, $end])->delete();
        Image::whereBetween('created_at', [$start, $end])->delete();

        return back()->with('success', 'Data successfully deleted between the selected dates.');
    }

}
