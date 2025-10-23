@extends('admin.layouts.dashboard')
@section('title', 'Resource List')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-3">
        <h1 class="display-6 fw-light">
            Resources <span class="fw-bold" style="color: #12372A;">List</span>
        </h1>
        <a href="{{ route('resources.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <span class="me-2">+</span> Create Resource
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success border-0 rounded-3">
        {{ session('success') }}
    </div>
    @endif
    <form action="{{ route('resources.index') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="title" class="form-control" placeholder="Search by Title" value="{{ request('title') }}">
        </div>
        <div class="col-md-4">
            <input type="number" name="quantity" class="form-control" placeholder="Minimum Quantity" value="{{ request('quantity') }}">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('resources.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    {{-- Resources Table --}}
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead style="background-color: #cbdf72;">
                        <tr>
                            <th>Title</th>
                            <th>Quantity</th>
                            <th>Sponsor</th>
                            <th>Image</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($resource as $item)
                        <tr class="border-bottom">
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->sponsor->name ?? '-' }}</td>
                            <td>
                                @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}"
                                    class="rounded-circle"
                                    style="width:50px; height:50px; object-fit:cover;"
                                    alt="Resource Image">
                                @else
                                <span class="text-muted fst-italic">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{-- Show Modal --}}
                                <a href="#"
                                    class="text-primary me-2 action-icon"
                                    title="View"
                                    data-bs-toggle="modal"
                                    data-bs-target="#resourceModal"
                                    data-title="{{ $item->title }}"
                                    data-quantity="{{ $item->quantity }}"
                                    data-sponsor="{{ $item->sponsor->name ?? '-' }}"
                                    data-image="{{ $item->image ? asset('storage/' . $item->image) : '' }}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('resources.edit', $item->id) }}" class="text-warning me-2" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('resources.destroy', $item->id) }}"
                                    method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn p-0 border-0 bg-transparent text-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No resources found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Resource Modal --}}
<div class="modal fade" id="resourceModal" tabindex="-1" aria-labelledby="resourceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-secondary">
                <h5 class="modal-title" id="resourceModalLabel">Resource Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Resource Image" class="rounded-circle shadow-sm mb-3" style="width:100px; height:100px; object-fit:cover;">
                <ul class="list-group list-group-flush text-start">
                    <li class="list-group-item"><strong>Title:</strong> <span id="modalTitle"></span></li>
                    <li class="list-group-item"><strong>Quantity:</strong> <span id="modalQuantity"></span></li>
                    <li class="list-group-item"><strong>Sponsor:</strong> <span id="modalSponsor"></span></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    body {
        background-color: transparent !important;
    }

    .table {
        border-collapse: separate;
        border-spacing: 0 0.5rem;
    }

    .thead-custom th {
        background-color: #cbdf72;
        border-top: none;
        border-bottom: 2px solid #dee2e6;
    }

    .table td {
        border-top: none;
        border-bottom: 1px solid #e9ecef;
    }

    .table th:not(:last-child),
    .table td:not(:last-child) {
        border-right: none;
    }

    i.bi {
        font-size: 1.2rem;
    }

    a.text-warning:hover i {
        color: #d39e00;
    }

    button.text-danger:hover i {
        color: #c82333;
    }

    .table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .action-icon i {
        font-size: 1.3rem;
        transition: color 0.2s, transform 0.2s;
    }

    .action-icon:hover i {
        transform: scale(1.1);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal show
        const resourceModal = document.getElementById('resourceModal');
        resourceModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            resourceModal.querySelector('#modalTitle').textContent = button.getAttribute('data-title');
            resourceModal.querySelector('#modalQuantity').textContent = button.getAttribute('data-quantity');
            resourceModal.querySelector('#modalSponsor').textContent = button.getAttribute('data-sponsor');

            const imgSrc = button.getAttribute('data-image');
            const modalImage = resourceModal.querySelector('#modalImage');
            if (imgSrc) {
                modalImage.src = imgSrc;
                modalImage.style.display = 'block';
            } else {
                modalImage.style.display = 'none';
            }
        });

        // SweetAlert2 Delete
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush

@endsection