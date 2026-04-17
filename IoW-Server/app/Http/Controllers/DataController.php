<?php

namespace App\Http\Controllers;

use App\Models\DataType;
use App\Models\Image;
use App\Models\SensorMessage;
use App\Services\AggregateService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use function PHPSTORM_META\map;

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
    public function show(DataType $data_type)
    {

        $messagesQuarry = $data_type->messages()
            ->with('sensor')
            ->orderBy('created_at', 'asc');

        //Getting raw data
        $raw_data = (clone $messagesQuarry)->paginate(10);

        // Checking if is there any data
        if ($raw_data->isEmpty()) {
            return view('data.show', [
                'title' => ucfirst($data_type->data_type),
                'data_type' => $data_type,
                'raw_data' => $raw_data,
                'data_exists' => false
            ]);
        }

        //Checking if chart setting are set
        if (is_null($data_type->aggregate_by)
            or is_null($data_type->aggregate_length
                or is_null($data_type->diagram_type)
                    or is_null($data_type->time))) {
            return view('data.show', [
                'title' => ucfirst($data_type->data_type),
                'data_type' => $data_type,
                'raw_data' => $raw_data,
                'data_exists' => true,
                'able_to_chart' => false
            ]);
        }

        $unit = $data_type->aggregate_time; // hour | day | month | year
        $size = $data_type->aggregate_length;

        $messages = (clone $messagesQuarry)->whereNull('error_message')->get();
        $chart_data = (new \App\Services\BucketService)->createBucket($messages, $unit, $size);

        // Checking if making a chart is possible
        if($chart_data->isEmpty()){
            return view('data.show', [
                'title' => ucfirst($data_type->data_type),
                'data_type' => $data_type,
                'raw_data' => $raw_data,
                'data_exists' => false,
                'able_to_chart' => false
            ]);
        }

        // Getting the label for the chart
        $labels = $chart_data->pluck('label')->toArray();

        // If duration is set to 0 then just get the values if not aggregate
        if($size == 0){
            $values = $chart_data->pluck('values')->toArray();
        }else{
            $values = (new \App\Services\AggregateService)->aggregate($chart_data->pluck('values')->toArray(), $data_type->aggregate_by);
        }

        // Getting the chart name
        $chart_name = $data_type->data_type . " (" . $data_type->unit . ")";

        // Returning the full values
        return view('data.show', [
            'title' => ucfirst($data_type->data_type),
            'data_type' => $data_type,
            'raw_data' => $raw_data,
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

    // Add chart settings
    public function storeChartSettings(Request $request, DataType $data_type){
        $validated = $request->validate([
            'aggregate_by' => ['required', 'string', 'in:avg,sum,max,min,median,mode,count'],
            'aggregate_time' => ['required', 'string', 'in:hour,day,month,year'],
            'aggregate_length' => [
                'required',
                'integer',
                'min:0',
                Rule::when(
                    $request->aggregate_time === 'hour',
                    ['max:24']
                ),
            ],
            'diagram_type' => ['required', 'string', 'in:bar,line'],
        ]);

        $data_type->aggregate_by = $validated['aggregate_by'];
        $data_type->aggregate_time = $validated['aggregate_time'];
        $data_type->aggregate_length = $validated['aggregate_length'];
        $data_type->diagram_type = $validated['diagram_type'];
        $data_type->save();

        return back();
    }

}
