<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donations Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th {
            border-top: none;
            font-weight: 600;
            background-color: #f8f9fa;
            color: #495057;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px;
        }
        .table td {
            padding: 12px 16px;
            vertical-align: middle;
        }
        .progress {
            height: 6px;
            border-radius: 3px;
        }
        .donation-title {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.95rem;
        }
        .donation-description {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 2px;
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 12px;
        }
        .action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 6px;
            transition: all 0.2s ease;
            margin: 0 2px;
        }
        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-edit {
            background: #e8f4fd;
            color: #0d6efd;
        }
        .btn-edit:hover {
            background: #0d6efd;
            color: white;
        }
        .btn-delete {
            background: #fde8e8;
            color: #dc3545;
        }
        .btn-delete:hover {
            background: #dc3545;
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
        }
        .amount-cell {
            font-weight: 600;
            color: #2c3e50;
        }
        .progress-cell {
            min-width: 120px;
        }
        .donors-cell {
            text-align: center;
        }
        .empty-state {
            padding: 3rem !important;
        }
        .empty-state i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }
    </style>
     <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="images/favicon.svg" type="x-icon" />
  <title>Eco Event</title>

  <!-- ========== All CSS files linkup ========= -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/lineicons.css')}}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{ asset('css/materialdesignicons.min.css')}}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{ asset('css/fullcalendar.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/fullcalendar.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/main.css')}}" />
</head>
@extends('admin.layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold text-dark">Donations Management</h1>
                <p class="text-muted mb-0">Manage all donation campaigns</p>
            </div>
            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#createDonationModal">
                <i class="fas fa-plus me-2"></i>Create Donation
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted">Total Donations</h6>
                                <h3 class="fw-bold">{{ $donations->count() }}</h3>
                            </div>
                            <div class="align-self-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#0d6efd" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted">Total Raised</h6>
                                <h3 class="fw-bold">${{ number_format($donations->sum('reached'), 2) }}</h3>
                            </div>
                            <div class="align-self-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#198754" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted">Total Donors</h6>
                                <h3 class="fw-bold">{{ $donations->sum('donor_count') }}</h3>
                            </div>
                            <div class="align-self-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fd7e14" class="bi bi-people-fill" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

         <!-- Donations Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Campaign</th>
                                <th>Target</th>
                                <th class="text-center">Progress</th>
                                <th class="text-center">Donors</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donations as $donation)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($donation->image)
                                        <img src="{{ asset('storage/donations/' . $donation->image) }}" 
                                             alt="{{ $donation->title }}" 
                                             class="rounded me-3"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                        <div class="rounded me-3 d-flex align-items-center justify-content-center bg-light text-muted"
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-heart fa-sm"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <div class="donation-title">{{ $donation->title }}</div>
                                            <div class="donation-description">
                                                {{ Str::limit($donation->description, 50) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="amount-cell">
                                    ${{ number_format($donation->amount, 2) }}
                                </td>
                                <td class="progress-cell">
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2">
                                            @php
                                                $progress = ($donation->reached / $donation->amount) * 100;
                                                $progress = min($progress, 100);
                                                $progressClass = $progress >= 100 ? 'bg-success' : 'bg-primary';
                                            @endphp
                                            <div class="progress-bar {{ $progressClass }}" 
                                                 style="width: {{ $progress }}%">
                                            </div>
                                        </div>
                                        <small class="text-nowrap" style="font-size: 0.75rem; min-width: 40px;">
                                            {{ number_format($progress, 1) }}%
                                        </small>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        ${{ number_format($donation->reached, 2) }} raised
                                    </small>
                                </td>
                                <td class="donors-cell">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fas fa-users me-1 text-muted" style="font-size: 0.8rem;"></i>
                                        <span class="fw-semibold">{{ $donation->donor_count }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($donation->reached >= $donation->amount)
                                    <span class="badge status-badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Completed
                                    </span>
                                    @else
                                    <span class="badge status-badge bg-primary">
                                        <i class="fas fa-spinner me-1"></i>Active
                                    </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="action-btn btn-edit edit-donation-btn" 
                                                data-bs-toggle="modal" data-bs-target="#editDonationModal"
                                                data-donation-id="{{ $donation->idDonation }}"
                                                data-donation-title="{{ $donation->title }}"
                                                data-donation-description="{{ $donation->description }}"
                                                data-donation-amount="{{ $donation->amount }}"
                                                data-donation-payment-methods="{{ $donation->payment_methods }}"
                                                data-donation-image="{{ $donation->image ? asset('storage/donations/' . $donation->image) : '' }}"
                                                title="Edit Donation">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" width="1em" fill="currentColor" viewBox="0 0 512 512">
                                                <path d="M495.2 27.6c-18.7-18.7-49-18.7-67.7 0l-12.8 12.8L477.6 122.3l12.8-12.8c18.7-18.7 18.7-49 0-67.7l-12.8-12.8zm-155.6 156.4L188.7 334.9c-7.9 7.9-12.2 18.4-12.2 29.5L176.8 456l-98 19.6c-10.7 2.1-21.7-1.1-29.8-9.1s-11.2-18.8-9.1-29.8l19.6-98c.1-4.7 1-9.3 2.6-13.6c1.6-4.3 3.9-8.4 6.8-12.2L312.3 84.8c18.7-18.7 49-18.7 67.7 0s18.7 49 0 67.7L339.6 200.2zM216 480H40c-22.1 0-40-17.9-40-40V176c0-22.1 17.9-40 40-40h128c11 0 20-9 20-20s-9-20-20-20H40c-44.2 0-80 35.8-80 80V440c0 44.2 35.8 80 80 80h176c11 0 20-9 20-20s-9-20-20-20z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('donations.destroy', $donation->idDonation) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-delete" 
                                                    onclick="return confirm('Are you sure you want to delete this donation?')"
                                                    title="Delete Donation">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" width="1em" fill="currentColor" viewBox="0 0 448 512">
                                                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 30.9 27.2 53 58.6 53H336.2c31.3 0 57-22.1 58.6-53L416 128z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p class="text-muted mt-2 mb-0">No donations found</p>
                                    <small class="text-muted">Create your first donation campaign to get started</small>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Donation Modal -->
    <div class="modal fade" id="createDonationModal" tabindex="-1" aria-labelledby="createDonationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="createDonationModalLabel">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>Create New Donation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createDonationForm" method="POST" action="{{ route('donations.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" required placeholder="Enter donation title">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Target Amount <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="amount" class="form-control" required min="1" step="0.01" placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Describe the purpose of this donation"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Payment Methods <span class="text-danger">*</span></label>
                                    <input type="text" name="payment_methods" class="form-control" required placeholder="e.g. Credit Card, PayPal">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Image (optional)</label>
                                    <input type="file" name="image" id="createImage" class="form-control" accept="image/*">
                                    <img id="createImagePreview" class="image-preview mt-2 rounded" src="" alt="Image preview" 
                                         style="max-width: 150px; max-height: 150px; display: none;">
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Create Donation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Donation Modal -->
    <div class="modal fade" id="editDonationModal" tabindex="-1" aria-labelledby="editDonationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editDonationModalLabel">
                        <i class="fas fa-edit me-2 text-warning"></i>Edit Donation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editDonationForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="editTitle" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Target Amount <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="amount" id="editAmount" class="form-control" required min="1" step="0.01">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Payment Methods <span class="text-danger">*</span></label>
                                    <input type="text" name="payment_methods" id="editPaymentMethods" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Image (optional)</label>
                                    <input type="file" name="image" id="editImage" class="form-control" accept="image/*">
                                    
                                    <!-- Current Image Display -->
                                    <div id="currentImageContainer" class="mt-2">
                                        <small class="text-muted">Current Image:</small>
                                        <div id="currentImage" class="mt-1"></div>
                                    </div>
                                    
                                    <!-- New Image Preview -->
                                    <img id="editImagePreview" class="image-preview mt-2 rounded" src="" alt="New image preview" 
                                         style="max-width: 150px; max-height: 150px; display: none;">
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Donation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editDonationModal');
            
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                
                const donationId = button.getAttribute('data-donation-id');
                const donationTitle = button.getAttribute('data-donation-title');
                const donationDescription = button.getAttribute('data-donation-description');
                const donationAmount = button.getAttribute('data-donation-amount');
                const donationPaymentMethods = button.getAttribute('data-donation-payment-methods');
                const donationImage = button.getAttribute('data-donation-image');
                
                document.getElementById('editTitle').value = donationTitle || '';
                document.getElementById('editDescription').value = donationDescription || '';
                document.getElementById('editAmount').value = donationAmount || '';
                document.getElementById('editPaymentMethods').value = donationPaymentMethods || '';
                
                const currentImageContainer = document.getElementById('currentImage');
                if (donationImage) {
                    currentImageContainer.innerHTML = `
                        <img src="${donationImage}" class="rounded border" alt="Current image"
                             style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remove_image" id="removeImage">
                            <label class="form-check-label text-danger small" for="removeImage">
                                Remove current image
                            </label>
                        </div>
                    `;
                } else {
                    currentImageContainer.innerHTML = '<span class="text-muted fst-italic small">No image</span>';
                }
                
                document.getElementById('editDonationForm').action = `/donations/${donationId}`;
            });

            // Image preview for create form
            document.getElementById('createImage').addEventListener('change', function(e) {
                const preview = document.getElementById('createImagePreview');
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(this.files[0]);
                } else {
                    preview.style.display = 'none';
                }
            });

            // Image preview for edit form
            document.getElementById('editImage').addEventListener('change', function(e) {
                const preview = document.getElementById('editImagePreview');
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(this.files[0]);
                } else {
                    preview.style.display = 'none';
                }
            });

            // Reset create form when modal is closed
            document.getElementById('createDonationModal').addEventListener('hidden.bs.modal', function() {
                document.getElementById('createDonationForm').reset();
                document.getElementById('createImagePreview').style.display = 'none';
            });
        });
    </script>
    
@endsection   
</html>