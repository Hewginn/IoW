@extends('layouts.main')

@section('content')
    @if(is_null($data_types))
        <div class="text-center">
            <p>There are no data.</p>
        </div>
    @else
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif
        <div class="container py-4">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($data_types as $data_type)
                    <div class="col-md-4">
                        <div class="card h-100 align-items-center p-3">
                            <img src="{{ asset('storage/' . $data_type->image_path) }}" class="card-img-top img-fluid w-50" alt="Image of data type">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $data_type->data_type }}</h5>
                                <a href="{{ route('data.show', [$data_type]) }}" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-4">
                    <div class="card h-100 align-items-center">
                        <img src="{{ asset('storage/' . 'data_types_images/ImageIcon.png') }}" class="card-img-top img-fluid w-50" alt="Image of data type">
                        <div class="card-body text-center">
                            <h5 class="card-title">Images</h5>
                            <a href="{{ route('images.index') }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white fw-bold">
                    Delete Data And Images Between Dates
                </div>

                <div class="card-body">
                    <form action="{{ route('data.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>

                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-danger">
                                Delete Records
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
