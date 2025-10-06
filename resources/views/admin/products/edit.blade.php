@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Edit Product</h4>
                            <p class="text-muted mb-0">Update product details for {{ $event->title }}</p>
                        </div>
                        <a href="{{ route('products.index', $event->id) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Products
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', ['event' => $event->id, 'product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Please fix the following errors:
                                <ul class="mb-0 mt-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-12 col-md-8">
                                <!-- Product Information -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3">Product Information</h5>
                                    
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', $product->name) }}" 
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" 
                                                  name="description" 
                                                  rows="4">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" 
                                                           class="form-control @error('price') is-invalid @enderror" 
                                                           id="price" 
                                                           name="price" 
                                                           step="0.01" 
                                                           min="0" 
                                                           value="{{ old('price', $product->price) }}" 
                                                           required>
                                                </div>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                                <input type="number" 
                                                       class="form-control @error('quantity') is-invalid @enderror" 
                                                       id="quantity" 
                                                       name="quantity" 
                                                       min="0" 
                                                       value="{{ old('quantity', $product->quantity) }}" 
                                                       required>
                                                @error('quantity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <!-- Product Images -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3">Product Images</h5>
                                    
                                    <!-- Current Images -->
                                    @if($product->images->isNotEmpty())
                                        <div class="mb-3">
                                            <label class="form-label">Current Images</label>
                                            <div class="row g-2">
                                                @foreach($product->images as $image)
                                                    <div class="col-6">
                                                        <div class="position-relative">
                                                            <img src="{{ Storage::url($image->path) }}" 
                                                                 class="img-thumbnail w-100" 
                                                                 style="height: 100px; object-fit: cover;"
                                                                 alt="Product image">
                                                            <div class="position-absolute top-0 end-0 m-1">
                                                                <span class="badge bg-dark">{{ $loop->iteration }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small class="text-muted">Uploading new images will replace all current images.</small>
                                        </div>
                                    @endif

                                    <!-- Image Upload -->
                                    <div class="mb-3">
                                        <label for="images" class="form-label">
                                            {{ $product->images->isNotEmpty() ? 'Replace Images' : 'Upload Images' }}
                                        </label>
                                        <input type="file" 
                                               class="form-control @error('images.*') is-invalid @enderror" 
                                               id="images" 
                                               name="images[]" 
                                               multiple 
                                               accept="image/*">
                                        @error('images.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            You can select multiple images. Supported formats: JPG, PNG, JPEG, GIF, SVG. Max size: 2MB per image.
                                        </div>
                                    </div>

                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="d-none">
                                        <label class="form-label">Image Preview</label>
                                        <div class="row g-2" id="previewContainer"></div>
                                    </div>
                                </div>

                                <!-- Quick Stats -->
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Product Stats</h6>
                                        <div class="small">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span>Created:</span>
                                                <span>{{ $product->created_at->format('M j, Y') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-1">
                                                <span>Last Updated:</span>
                                                <span>{{ $product->updated_at->format('M j, Y') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-1">
                                                <span>Status:</span>
                                                <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }}">
                                                    {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal">
                                        <i class="bi bi-trash me-2"></i>Delete Product
                                    </button>
                                    <div>
                                        <a href="{{ route('products.index', $event->id) }}" class="btn btn-secondary me-2">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle me-2"></i>Update Product
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $product->name }}</strong>?</p>
                <p class="text-danger">This action cannot be undone. All product images will also be deleted.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('products.destroy', ['event' => $event->id, 'product' => $product->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 12px;
    }
    
    .card-header {
        border-radius: 12px 12px 0 0 !important;
        border-bottom: 1px solid #e9ecef;
    }
    
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .img-thumbnail {
        border-radius: 8px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview functionality
        const imageInput = document.getElementById('images');
        const imagePreview = document.getElementById('imagePreview');
        const previewContainer = document.getElementById('previewContainer');

        imageInput.addEventListener('change', function(e) {
            const files = e.target.files;
            previewContainer.innerHTML = '';
            
            if (files.length > 0) {
                imagePreview.classList.remove('d-none');
                
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const col = document.createElement('div');
                            col.className = 'col-6';
                            
                            const imgWrapper = document.createElement('div');
                            imgWrapper.className = 'position-relative';
                            
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'img-thumbnail w-100';
                            img.style.height = '100px';
                            img.style.objectFit = 'cover';
                            
                            const badge = document.createElement('div');
                            badge.className = 'position-absolute top-0 end-0 m-1';
                            
                            const span = document.createElement('span');
                            span.className = 'badge bg-primary';
                            span.textContent = i + 1;
                            
                            badge.appendChild(span);
                            imgWrapper.appendChild(img);
                            imgWrapper.appendChild(badge);
                            col.appendChild(imgWrapper);
                            previewContainer.appendChild(col);
                        };
                        
                        reader.readAsDataURL(file);
                    }
                }
            } else {
                imagePreview.classList.add('d-none');
            }
        });

        // Price input validation
        const priceInput = document.getElementById('price');
        priceInput.addEventListener('input', function() {
            if (this.value < 0) {
                this.value = 0;
            }
        });

        // Quantity input validation
        const quantityInput = document.getElementById('quantity');
        quantityInput.addEventListener('input', function() {
            if (this.value < 0) {
                this.value = 0;
            }
        });
    });
</script>
@endpush