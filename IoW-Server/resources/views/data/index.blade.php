@extends('layouts.main')

@section('content')
    @if(is_null($data_types))
        <div class="text-center">
            <p>There are no data.</p>
        </div>
    @else
        <div class="container py-4">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($data_types as $data_type)
                    <div class="col-md-4">
                        <div class="card h-100 align-items-center">
                            @if(is_null($data_type->image_path))
                                <img src="{{ asset('storage/' . 'data_types_images/DataTypePlaceHolder.png') }}" class="card-img-top img-fluid w-50" alt="Image of data type">
                            @else
                                <img src="{{ asset('storage/' . $data_type->image_path) }}" class="card-img-top img-fluid w-50" alt="Image of data type">
                            @endif
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $data_type->data_type }}</h5>
                                <a href="{{ route('data.show', [$data_type]) }}" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @endif
@endsection
