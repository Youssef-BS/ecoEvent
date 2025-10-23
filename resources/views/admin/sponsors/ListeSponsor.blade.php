@extends('admin.layouts.dashboard')
@section('title', 'Sponsors List')

@section('content')
<div class="container py-5">

    {{-- Header and Create Button --}}
    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-3">
        <h1 class="display-6 fw-light" style="color: #12372A;">
            Sponsors <span class="fw-bold" style="color: #12372A;">List</span>
        </h1>

        <a href="{{ route('sponsors.create') }}" class="btn btn-primary btn-lg shadow-sm rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Add a Sponsor
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success border-0 rounded-3 shadow-sm">
        {{ session('success') }}
    </div>
    @endif
    <form action="{{ route('sponsors.ListeSponsor') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" placeholder="Search by name" value="{{ request('name') }}">
        </div>
        <div class="col-md-4">
            <select name="contributionType" class="form-select">
                <option value="">All Contribution Types</option>
                @foreach(App\ContributionType::cases() as $type)
                <option value="{{ $type->value }}" {{ request('contributionType') == $type->value ? 'selected' : '' }}>
                    {{ ucfirst($type->value) }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('sponsors.ListeSponsor') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>
    {{-- Sponsors Table --}}
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead style="background-color: #cbdf72">
                        <tr>
                            <th scope="col" class="py-3 ps-4 rounded-top-start">Logo</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Contribution</th>
                            <th scope="col">Email</th>
                            <th scope="col" class="text-center rounded-top-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sponsors as $sponsor)
                        <tr>
                            <td class="ps-4">
                                @if($sponsor->logo)
                                <img src="{{ asset('storage/' . $sponsor->logo) }}"
                                    alt="{{ $sponsor->name }}"
                                    class="rounded-circle shadow-sm"
                                    style="width:50px; height:50px; object-fit:cover;">
                                @else
                                <span class="text-muted fst-italic">No logo</span>
                                @endif
                            </td>
                            <td class="fw-bold text-dark">{{ $sponsor->name }}</td>
                            <td><span class="badge bg-primary-subtle text-primary">{{ ucfirst($sponsor->contribution) }}</span></td>
                            <td>
                                <a href="mailto:{{ $sponsor->email }}" class="text-decoration-none text-dark">
                                    {{ $sponsor->email }}
                                </a>
                            </td>
                            <td class="text-center">
                                {{-- View Modal --}}
                                <a href="#"
                                    class="text-primary me-2 action-icon"
                                    title="View"
                                    data-bs-toggle="modal"
                                    data-bs-target="#sponsorModal"
                                    data-name="{{ $sponsor->name }}"
                                    data-contribution="{{ ucfirst($sponsor->contribution) }}"
                                    data-email="{{ $sponsor->email }}"
                                    data-phone="{{ $sponsor->phone ?? '-' }}"
                                    data-website="{{ $sponsor->website ?? '-' }}"
                                    data-logo="{{ $sponsor->logo ? asset('storage/' . $sponsor->logo) : '' }}"
                                    data-avg="{{ $sponsor->avg_satisfaction }}"
                                    data-impact="{{ $sponsor->impact_score }}"
                                    data-performance="{{ $sponsor->performance_level }}"
                                    data-events="{{ $sponsor->events_sponsored_count }}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('sponsors.edit', $sponsor->id) }}" class="text-dark me-2 action-icon" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('sponsors.destroy', $sponsor->id) }}"
                                    method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn p-0 border-0 bg-transparent text-danger action-icon" title="Delete">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-box-seam me-2"></i> No sponsors found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Sponsor Details Modal --}}
<div class="modal fade" id="sponsorModal" tabindex="-1" aria-labelledby="sponsorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-secondary">
                <h5 class="modal-title" id="sponsorModalLabel">Sponsor Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img id="modalLogo" src="" alt="Logo" class="rounded-circle shadow-sm" style="width:100px; height:100px; object-fit:cover;">
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Name:</strong> <span id="modalName"></span></li>
                    <li class="list-group-item"><strong>Contribution:</strong> <span id="modalContribution"></span></li>
                    <li class="list-group-item"><strong>Email:</strong> <span id="modalEmail"></span></li>
                    <li class="list-group-item"><strong>Phone:</strong> <span id="modalPhone"></span></li>
                    <li class="list-group-item"><strong>Website:</strong> <span id="modalWebsite"></span></li>
                    <li class="list-group-item"><strong>Avg Satisfaction:</strong> <span id="modalAvg"></span></li>
                    <li class="list-group-item"><strong>Impact Score:</strong> <span id="modalImpact"></span></li>
                    <li class="list-group-item"><strong>Performance Level:</strong> <span id="modalPerformance"></span></li>
                    <li class="list-group-item"><strong>Events Sponsored:</strong> <span id="modalEvents"></span></li>
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

    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #343a40 !important;
    }

    .table tbody tr td {
        background-color: #fff;
        border: none;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .card .table-responsive {
        margin: 0;
    }

    .action-icon i {
        font-size: 1.3rem;
        transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
    }

    .action-icon:hover i {
        transform: scale(1.1);
    }

    .text-primary:hover {
        color: #0d6efd !important;
    }

    .text-dark:hover {
        color: #343a40 !important;
    }

    .text-danger:hover {
        color: #c9302c !important;
    }

    .table tbody tr:first-child td:first-child {
        border-top-left-radius: 0.5rem;
    }

    .table tbody tr:first-child td:last-child {
        border-top-right-radius: 0.5rem;
    }

    .table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 0.5rem;
    }

    .table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 0.5rem;
    }
</style>
@endpush

@push('scripts')
{{-- Bootstrap Bundle --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal sponsor details
        const sponsorModal = document.getElementById('sponsorModal');
        sponsorModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;

            sponsorModal.querySelector('#modalName').textContent = button.getAttribute('data-name');
            sponsorModal.querySelector('#modalContribution').textContent = button.getAttribute('data-contribution');
            sponsorModal.querySelector('#modalEmail').textContent = button.getAttribute('data-email');
            sponsorModal.querySelector('#modalPhone').textContent = button.getAttribute('data-phone');
            sponsorModal.querySelector('#modalWebsite').textContent = button.getAttribute('data-website');
            sponsorModal.querySelector('#modalAvg').textContent = button.getAttribute('data-avg');
            sponsorModal.querySelector('#modalImpact').textContent = button.getAttribute('data-impact');
            sponsorModal.querySelector('#modalPerformance').textContent = button.getAttribute('data-performance');
            sponsorModal.querySelector('#modalEvents').textContent = button.getAttribute('data-events');

            const logo = button.getAttribute('data-logo');
            const modalLogo = sponsorModal.querySelector('#modalLogo');
            if (logo) {
                modalLogo.src = logo;
                modalLogo.style.display = 'block';
            } else {
                modalLogo.style.display = 'none';
            }
        });

        // SweetAlert2 for delete
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