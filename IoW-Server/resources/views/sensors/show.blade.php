@extends('layouts.main')


@section('content')

    @include('components.details')

    <div class="w-100">
        <h1 class="text-xl-center py-4 fw-bolder">Sensors Messages</h1>
    </div>

    <table class="table table-hover justify-content-center">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Value</th>
            <th scope="col">Unit</th>
            <th scope="col">Created At</th>
            <th scope="col">Error</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sensorMessages as $sensorMessage)

            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $sensorMessage->created_at }}</td>
                <td>{{ $sensorMessage->value_type }}</td>
                <td>{{ $sensorMessage->value }}</td>
                <td>{{ $sensorMessage->unit }}</td>
                @if(is_null($sensorMessage->error_message))
                    <td> - </td>
                @else
                    <td> {{ $sensorMessage->error_message }} </td>
                @endif
            </tr>

        @endforeach
        </tbody>
    </table>


@endsection
