@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h4>Change Password</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('changePassword') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input
                                    type="password"
                                    name="current_password"
                                    id="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    required
                                >
                                @error('current_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input
                                    type="password"
                                    name="new_password"
                                    id="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror"
                                    required
                                >
                                @error('new_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Confirm New Password --}}
                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <input
                                    type="password"
                                    name="new_password_confirmation"
                                    id="new_password_confirmation"
                                    class="form-control"
                                    required
                                >
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
