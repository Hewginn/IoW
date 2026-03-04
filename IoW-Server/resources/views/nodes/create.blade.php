@extends('layouts.main')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-6 w-50">
            <form class="p-3" action="{{ route('nodes.store') }}" method="POST">
                @csrf
                <div class="mb-3"><label for="name" class="form-label">Device Name</label><input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}"></div>
                <div class="mb-3"><label for="password" class="form-label">Password</label><input type="password" class="form-control" id="password" name="password" required></div>
                <div class="mb-3"><label for="password_confirmation" class="form-label">Confirm Password</label><input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required></div>
                <div class="mb-3"><label for="location" class="form-label">Location</label><input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}"></div>
                <div class="mb-3"><label for="main_unit" class="form-label">Main Unit</label><input type="text" class="form-control" id="main_unit" name="main_unit" value="{{ old('main_unit') }}"></div>
                <div class="mb-3">
                    <label for="status" class="form-label">Choose Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                        <option value="In Development">In Development</option>
                        <option value="Faulty">Faulty</option>
                    </select>
                </div>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="control" name="control" value="1" checked>
                        <label class="form-check-label" for="control">Active</label>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="analyze_images" name="analyze_images" value="1" checked>
                        <label class="form-check-label" for="analyze_images">Analyze the images sent by this node</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="p-3 m-3 text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>
@endsection
