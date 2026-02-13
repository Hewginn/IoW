@extends('layouts.main')

@section('content')

    <div class="w-100">
        <h1 class="text-xl-center py-4 fw-bolder">Images</h1>
    </div>

    <table class="table table-hover justify-content-center">
        <thead>
        <tr class="text-center align-middle">
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Created At</th>
            <th scope="col">Visions</th>
            <th scope="col">Error</th>
            <th scope="col">Full Image</th>
            <th scope="col">Camera</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach($images as $image)

            <tr class="text-center align-middle">
                <th scope="row">{{ $loop->iteration }}</th>
                <td>
                    <img src="{{ url('/camera-image/' . $image->path) }}" alt="Image" class="img-fluid
                     mb-2 border border-primary" style="max-width: 150px;">
                </td>
                <td>{{ $image->created_at }}</td>
                @if($image->vision)
                    <td> <a href="{{ route('images.vision', $image) }}">{{ $image->vision->result }}</a></td>
                @else
                    <td> - </td>
                @endif
                @if(is_null($image->error_message))
                    <td> - </td>
                @else
                    <td> {{ $image->error_message }} </td>
                @endif
                <td> <a href="{{ url('/camera-image/' . $image->path) }}">Show</a></td>
                <td> <a href="{{ route('cameras.show', $image->camera_id) }}">Go to camera</a></td>
                <td>
                    <form action="{{ route('images.destroy', $image) }}" method="POST" class="d-inline">
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
        {{ $images->links('pagination::bootstrap-5') }}
    </div>
    <a href="{{ route('data.index') }}">Go to all data</a>
@endsection
