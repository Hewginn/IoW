@extends('layouts.main')

@section('content')

    @if(!$data_exists)
        <div class="alert alert-danger mt-3">
            There is no data!
        </div>
    @else

        @if($able_to_chart)
            <div class="container mt-4">
                <div class="card">
                    <div class="card-body">
                        <canvas id="lineChart"></canvas>
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
            @foreach($datas as $data)

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
            {{ $datas->links('pagination::bootstrap-5') }}
        </div>
        <a href="{{ route('data.index') }}">Go to all data</a>

        @if($able_to_chart)
            <script>
                const labels = {!! json_encode($labels) !!};
                const values = {!! json_encode($values) !!};

                new Chart(document.getElementById('lineChart'), {
                    type: 'line',
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
