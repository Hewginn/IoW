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
            <th scope="col">Created At</th>
            <th scope="col">Value Type</th>
            <th scope="col">Value</th>
            <th scope="col">Unit</th>
            <th scope="col">Error</th>
            <th scope="col">Delete</th>
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
                <td>
                    <form action="{{ route('sensorMessage.destroy', $sensorMessage) }}" method="POST" class="d-inline">
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
        {{ $sensorMessages->links('pagination::bootstrap-5') }}
    </div>

    <a href="{{ route('nodes.show', [$node]) }}">Go to the node</a>


@endsection
