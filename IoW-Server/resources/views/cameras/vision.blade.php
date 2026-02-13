@extends('layouts.main')

@section('content')
    <div class="d-flex justify-content-center align-items-center gap-lg-5 mb-4">

        <div>
            <img src="{{ url('/camera-image/' . $image->path) }}" class="img-fluid border-2 border-secondary rounded" style="max-width: 250px;" alt="Image">
        </div>

        <div class="text-end">
            <h2>{{ $vision->result }}</h2>
        </div>

    </div>

    <table class="table table-hover justify-content-center">
        <thead>
        <tr class="text-center align-middle">
            <th scope="col">Class</th>
            <th scope="col">Probability</th>
        </tr>
        </thead>
        <tbody>
            <tr class="text-center align-middle">
                <td>
                    Healthy
                </td>
                <td>
                    {{ $vision->healthy }}
                </td>
            </tr>
            <tr class="text-center align-middle">
                <td>
                    Black Rot
                </td>
                <td>
                    {{ $vision->black_rot }}
                </td>
            </tr>
            <tr class="text-center align-middle">
                <td>
                    Leaf Blight
                </td>
                <td>
                    {{ $vision->leaf_blight }}
                </td>
            </tr>
            <tr class="text-center align-middle">
                <td>
                    Esca
                </td>
                <td>
                    {{ $vision->esca }}
                </td>
            </tr>
            <tr class="text-center align-middle">
                <td>
                    Powdery Mildew
                </td>
                <td>
                    {{ $vision->powdery_mildew }}
                </td>
            </tr>
            <tr class="text-center align-middle">
                <td>
                    Downy Mildew
                </td>
                <td>
                    {{ $vision->downy_mildew }}
                </td>
            </tr>
        </tbody>
    </table>
<a href="{{ route('images.index') }}">Go to all images</a>
@endsection
