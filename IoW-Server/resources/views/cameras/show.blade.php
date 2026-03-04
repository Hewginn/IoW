@extends('layouts.main')


@section('content')

    @include('components.details')

    <table class="table table-hover justify-content-center">
        <thead>
        <tr class="text-center align-middle">
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Created At</th>
            <th scope="col">Vision</th>
            <th scope="col">Error</th>
            <th scope="col">Full Image</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach($images as $image)

            @php
                if($image->vision !== null){
                    if($image->vision->result == "Healthy"){
                        $color = "text-success";
                    }elseif ($image->vision->result == "Can't make prediction"){
                        $color = "text-warning";
                    }else{
                        $color = "text-danger";
                    }
                }
            @endphp

            <tr class="text-center align-middle">
                <th scope="row">{{ $loop->iteration }}</th>
                <td>
                    <img src="{{ url('/camera-image/' . $image->path) }}" alt="Image" class="img-fluid
                     mb-2 border border-primary" style="max-width: 150px;">
                </td>
                <td>{{ $image->created_at }}</td>
                @if($image->vision)
                    <td> <a class="{{ $color }}" href="{{ route('images.vision', $image) }}">{{ $image->vision->result }}</a></td>
                @else
                    <td> - </td>
                @endif
                @if(is_null($image->error_message))
                    <td> - </td>
                @else
                    <td> {{ $image->error_message }} </td>
                @endif
                <td> <a href="{{ url('/camera-image/' . $image->path) }}">Show</a></td>
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

    <a href="{{ route('nodes.show', [$node]) }}">Go to the node</a>


@endsection
