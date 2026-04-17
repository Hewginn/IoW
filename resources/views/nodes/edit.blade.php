@extends('layouts.main')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-6 w-50">
            <form class="p-3" action="{{ route('nodes.update', [$node]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Device Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        required
                        value="{{ old('name', $node->name) }}"
                    >
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password (leave blank to keep current)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input
                        type="text"
                        class="form-control"
                        id="location"
                        name="location"
                        value="{{ old('location', $node->location) }}"
                    >
                </div>

                <div class="mb-3">
                    <label for="main_unit" class="form-label">Main Unit</label>
                    <input
                        type="text"
                        class="form-control"
                        id="main_unit"
                        name="main_unit"
                        value="{{ old('main_unit', $node->main_unit) }}"
                    >
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Choose Status</label>
                    <select name="status" id="status" class="form-select">
                        @foreach(['Online','Offline','In Development','Faulty'] as $status)
                            <option value="{{ $status }}" {{ old('status', $node->status) === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="control"
                            name="control"
                            value="1"
                            {{ old('control', $node->control) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="control">Active</label>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="analyze_images"
                            name="analyze_images"
                            value="1"
                            {{ old('analyze_images', $node->analyze_images) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="analyze_images">
                            Analyze the images sent by this node
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Node</button>
            </form>

            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="p-3 m-3 text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
