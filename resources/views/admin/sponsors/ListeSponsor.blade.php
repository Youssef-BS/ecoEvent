@extends('admin.layouts.dashboard')
@section('title', 'Sponsors List')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">Sponsors List</h1>
        <a href="{{ route('sponsors.create') }}" class="btn btn-primary btn-lg shadow-sm">+ Add</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Contribution</th>
                    <th>Email</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sponsors as $sponsor)
                <tr>
                    <td>
                        @if($sponsor->logo)
                        <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}" class="img-thumbnail" style="max-width:50px; max-height:50px;">
                        @else
                        <span class="text-muted fst-italic">No logo</span>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $sponsor->name }}</td>
                    <td>{{ ucfirst($sponsor->contribution->value) }}</td>
                    <td><a href="mailto:{{ $sponsor->email }}" class="text-decoration-none text-primary">{{ $sponsor->email }}</a></td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('sponsors.show', $sponsor->id) }}" class="btn btn-link text-success">View</a>
                            <a href="{{ route('sponsors.edit', $sponsor->id) }}" class="btn btn-link text-warning">Edit</a>
                            <form action="{{ route('sponsors.destroy', $sponsor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ce sponsor ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center fst-italic py-4">No sponsors found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection