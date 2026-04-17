@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-6 w-50">
            <form class="p-3" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3"><label for="email" class="form-label">Email address</label><input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required></div>
                <div class="mb-3"><label for="password" class="form-label">Password</label><input type="password" class="form-control" id="password" name="password" required></div>
                <button type="submit" class="btn btn-primary">Log in</button>
            </form>
            @if(Route::has('register.show'))
                <a class="btn btn-outline-primary w-50 ms-3" href="{{ route('register.show') }}" role="button">I don't have an account</a>
            @endif
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="p-3 m-3 text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-md-6 w-50">
            <img src="{{ url('/image/login_img.jpg') }}" class="rounded object-fit-cover" height="700px" width="100%" alt="Vineyard">
        </div>
    </div>
@endsection
