@extends('layouts.main')


@section('content')

    @include('components.details')

    <div class="w-100">
        <h1 class="text-xl-center py-4 fw-bolder">Sensors</h1>
    </div>

    <table class="table table-hover justify-content-center">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Type</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sensors as $sensor)

            <tr>
                <th scope="row">{{ $sensor->name }}</th>
                <td>{{ $sensor->type }}</td>
                <td>{{ $sensor->status }}</td>
                <td> <a href="{{ route('sensors.show', [$sensor]) }}">Show</a></td>
            </tr>

        @endforeach
        </tbody>
    </table>


@endsection
