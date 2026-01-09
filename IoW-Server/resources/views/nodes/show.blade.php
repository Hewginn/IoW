@extends('layouts.main')


@section('content')

    <div class="container w-100 mb-3 border-bottom border-top border-primary border-2">
        <div class="row">
            <div class="col text-lg-center fw-bold py-4">Status</div>
            <div class="col text-lg-center fw-bold py-4">Location</div>
            <div class="col text-lg-center fw-bold py-4">Main Unit</div>
            <div class="col text-lg-center fw-bold py-4">Active</div>
            <div class="col text-lg-center fw-bold py-4">Delete</div>
        </div>

        <div class="row align-items-center">
            <div class="col text-lg-center py-4">{{ $node->status }}</div>

            <div class="col text-lg-center py-4">
                {{ is_null($node->location) ? '-' : $node->location }}
            </div>

            <div class="col text-lg-center py-4">
                {{ is_null($node->location) ? '-' : $node->main_unit }}
            </div>

            <div class="col text-lg-center py-4">
                <div class="form-check form-switch d-inline-block">
                    <input data-id="{{$node->id}}"
                           class="toggle-control form-check-input"
                           type="checkbox"
                        {{ $node->control ? 'checked' : '' }}>
                </div>
            </div>
            @include('components.control-toggle')

            <div class="col text-lg-center py-4">
                <form action="{{ route('nodes.destroy', [$node]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this node?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete Node</button>
                </form>
            </div>
        </div>
    </div>

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
    <div class="d-block">
        {{ $sensors->links('pagination::bootstrap-5') }}
    </div>
    <a href="{{ route('nodes.index') }}">Go to devices</a>

@endsection
