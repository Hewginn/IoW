@extends('layouts.main')

@section('content')

    <table class="table table-hover justify-content-center">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Location</th>
                <th scope="col">Status</th>
                <th scope="col">Main Unit</th>
                <th scope="col">Key</th>
                <th scope="col">Link</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nodes as $node)

                    <tr>
                        <th scope="row">{{ $node->name }}</th>
                        <td>{{ $node->location }}</td>
                        <td>{{ $node->status }}</td>
                        <td>{{ $node->main_unit }}</td>
                        <td>{{ $node->key }}</td>
                        <td> <a href="{{ route('nodes.show', [$node]) }}">Show</a></td>
                    </tr>

            @endforeach
        </tbody>
    </table>


@endsection
