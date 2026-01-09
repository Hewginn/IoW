@extends('layouts.main')

@section('content')

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
        </tr>
        </thead>
        <tbody>
        @foreach($datas as $data)

            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $data->created_at }}</td>
                <td>{{ $data->value_type }}</td>
                <td>{{ $data->value }}</td>
                <td>{{ $data->unit }}</td>
                @if(is_null($data->error_message))
                    <td> -</td>
                @else
                    <td> {{ $data->error_message }} </td>
                @endif
                <td> <a href="{{ route('sensors.show', [$data->sensor]) }}">Go to sensor</a></td>
            </tr>

        @endforeach
        </tbody>
    </table>
    <div class="d-block">
        {{ $datas->links('pagination::bootstrap-5') }}
    </div>
    <a href="{{ route('data.index') }}">Go to all data</a>
@endsection
