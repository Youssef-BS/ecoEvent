@extends('admin.layouts.dashboard')
@section('title', 'Resource List')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Resources</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('resources.create') }}" class="btn btn-success mb-3">Create New Resource</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Quantity</th>
                <th>Sponsor</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resource as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->sponsor->name ?? '-' }}</td>
                <td>
                    @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" width="50" alt="Resource Image">
                    @else
                    -
                    @endif
                </td>
                <td class="d-flex gap-1">
                    <a href="{{ route('resources.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('resources.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection