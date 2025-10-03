@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-plus-circle me-2"></i>Create New Product
                        </h4>
                        <a href="{{ route('products.index', $event->id) }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left me-1"></i>Back to Products
                        </a>
                    </div>
                    <p class="mb-0 opacity-75">Event: {{ $event->title }}</p>
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('products.store', $event->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">
                                    <i class="bi bi-tag me-1"></i>Product Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Enter product name"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">
                                    <i class="bi bi-text-paragraph me-1"></i>Description
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="Describe your product...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">
                                    <i class="bi bi-currency-dollar me-1"></i>Price <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           id="price" 
                                           name="price" 
                                           value="{{ old('price') }}" 
                                           step="0.01" 
                                           min="0" 
                                           placeholder="0.00"
                                           required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">
                                    <i class="bi bi-box me-1"></i>Quantity <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('quantity') is-invalid @enderror" 
                                       id="quantity" 
                                       name="quantity" 
                                       value="{{ old('quantity') }}" 
                                       min="0" 
                                       placeholder="Enter quantity"
                                       required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="images" class="form-label">
                                    <i class="bi bi-images me-1"></i>Product Images
                                </label>
                                <input type="file" 
                                       class="form-control @error('images.*') is-invalid @enderror" 
                                       id="images" 
                                       name="images[]" 
                                       multiple 
                                       accept="image/*">
                                <div class="form-text">
                                    You can select multiple images. Supported formats: JPG, PNG, JPEG, GIF, SVG. Max file size: 2MB each.
                                </div>
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <!-- Image preview container -->
                                <div id="imagePreview" class="mt-3 d-none">
                                    <h6 class="text-muted">Selected Images:</h6>
                                    <div class="d-flex flex-wrap gap-2" id="previewContainer"></div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-arrow-clockwise me-1"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="bi bi-plus-circle me-2"></i>Create Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 15px;
    }
    
    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }
    
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .preview-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: transform 0.2s;
    }
    
    .preview-image:hover {
        transform: scale(1.05);
        border-color: #0d6efd;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('images');
        const imagePreview = document.getElementById('imagePreview');
        const previewContainer = document.getElementById('previewContainer');
        
        // Image preview functionality
        imageInput.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            
            if (this.files.length > 0) {
                imagePreview.classList.remove('d-none');
                
                for (let file of this.files) {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'preview-image';
                            img.title = file.name;
                            previewContainer.appendChild(img);
                        }
                        
                        reader.readAsDataURL(file);
                    }
                }
            } else {
                imagePreview.classList.add('d-none');
            }
        });
        
        // Form validation
        const form = document.getElementById('productForm');
        form.addEventListener('submit', function(e) {
            const price = document.getElementById('price').value;
            const quantity = document.getElementById('quantity').value;
            
            if (price < 0) {
                e.preventDefault();
                alert('Price cannot be negative.');
                return;
            }
            
            if (quantity < 0) {
                e.preventDefault();
                alert('Quantity cannot be negative.');
                return;
            }
        });
    });
</script>
@endpush