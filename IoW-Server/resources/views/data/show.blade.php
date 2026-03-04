@extends('layouts.main')

@section('content')

    @if(!$data_exists)
        <div class="alert alert-danger mt-3">
            There is no data!
        </div>
    @else

        <div class="container mt-5">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Create Diagram</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('data.storeChartSettings', $data_type) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="aggregate_by" class="form-label">Aggregate Type</label>
                            <select name="aggregate_by" id="aggregate_by" class="form-select">
                                <option value="" >Select Aggregate Type</option>
                                <option value="avg" {{ $data_type->aggregate_by === 'avg' ? 'selected' : '' }} >Average</option>
                                <option value="sum" {{ $data_type->aggregate_by === 'sum' ? 'selected' : '' }} >Summary</option>
                                <option value="min" {{ $data_type->aggregate_by === 'min' ? 'selected' : '' }} >Minimum</option>
                                <option value="max" {{ $data_type->aggregate_by === 'max' ? 'selected' : '' }} >Maximum</option>
                                <option value="median" {{ $data_type->aggregate_by === 'median' ? 'selected' : '' }} >Median</option>
                                <option value="mode" {{ $data_type->aggregate_by === 'mode' ? 'selected' : '' }} >Mode</option>
                                <option value="count" {{ $data_type->aggregate_by === 'count' ? 'selected' : '' }} >Count</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="aggregate_interval" class="form-label">Bucket Duration (Hours)</label>
                            <input
                                type="number"
                                name="aggregate_interval"
                                id="aggregate_interval"
                                class="form-control"
                                min="0"
                                value="{{ old('aggregate_interval', $data_type->aggregate_interval ?? 0) }}"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="diagram_type" class="form-label">Diagram Type</label>
                            <select name="diagram_type" id="diagram_type" class="form-select">
                                <option value="">Choose Diagram Type</option>
                                <option value="line" {{$data_type->diagram_type === 'line' ? 'selected' : ''}} >Line Diagram</option>
                                <option value="bar" {{$data_type->diagram_type === 'bar' ? 'selected' : ''}}>Column Diagram</option>>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Create Diagram
                        </button>
                    </form>
                </div>
            </div>
        </div>


            @if($able_to_chart)
            <div class="container mt-4">
                <div class="card">
                    <div class="card-body">
                        <canvas id="chart"></canvas>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @else
            <div class="alert alert-danger mt-3">
                Unable to make chart! Unusable data!
            </div>
        @endif

        <div class="w-100">
            <h1 class="text-xl-center py-4 fw-bolder">Data</h1>
        </div>


        <table class="table table-hover justify-content-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Created At</th>
                <th scope="col">Value Type</th>
                <th scope="col">Value</th>
                <th scope="col">Unit</th>
                <th scope="col">Error</th>
                <th scope="col">Sensor</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($raw_data as $data)

                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $data->created_at }}</td>
                    <td>{{ $data_type->data_type }}</td>
                    <td>{{ $data->value }}</td>
                    <td>{{ $data_type->unit }}</td>
                    @if(is_null($data->error_message))
                        <td> -</td>
                    @else
                        <td> {{ $data->error_message }} </td>
                    @endif
                    <td> <a href="{{ route('sensors.show', [$data->sensor]) }}">Go to sensor</a></td>
                    <td>
                        <form action="{{ route('sensorMessage.destroy', $data) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <img src="{{ asset('storage/' . 'DeleteIcon.png') }}" alt="Delete" style="width:16px; height:16px;">
                            </button>
                        </form>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
        <div class="d-block">
            {{ $raw_data->links('pagination::bootstrap-5') }}
        </div>
        <a href="{{ route('data.index') }}">Go to all data</a>

        @if($able_to_chart)
            <script>
                const labels = {!! json_encode($labels) !!};
                const values = {!! json_encode($values) !!};

                new Chart(document.getElementById('chart'), {
                    type: "{{ $data_type->diagram_type }}",
                    data: {
                        labels: labels,
                        datasets: [{
                            label: "{{ $chart_name }}",
                            data: values,
                            borderColor: '#28a745',
                            backgroundColor: 'rgba(40, 167, 69, 0.2)',
                            borderWidth: 2,
                            tension: 0.3, // smooth curve
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            </script>
        @endif
    @endif

@endsection
