@include('client.layouts.navbar')
<head>
    <meta charset="utf-8">
    <title>Event Details - Charitize</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600;700&family=Open+Sans&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">{{ $event->title }}</h1>
                    <p class="text-muted mb-0">Manage event products and inventory</p>
                </div>
                <a href="{{ route('products.create', $event->id) }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add New Product
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($products->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-box-seam display-1 text-muted"></i>
                    </div>
                    <h3 class="text-muted">No Products Found</h3>
                    <p class="text-muted mb-4">Get started by adding your first product to this event.</p>
                    <a href="{{ route('products.create', $event->id) }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Create First Product
                    </a>
                </div>
            @else
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="card product-card h-100 shadow-sm">
                                <div class="card-img-top position-relative">
                                    @if($product->images->isNotEmpty())
                                        <div id="productCarousel{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach($product->images as $index => $image)
                                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}"> 
                                                         <img src="{{ Storage::url($image->path) }}"
                                                             class="d-block w-100" 
                                                             alt="{{ $product->name }}"
                                                             style="height: 200px; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if($product->images->count() > 1)
                                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel{{ $product->id }}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel{{ $product->id }}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }}">
                                            {{ $product->quantity }} in stock
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    <a href="{{ route('products.show', [$event, $product]) }}" class="text-decoration-none">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                    </a>
                                    <p class="card-text text-muted small line-clamp-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $product->description ?: 'No description available' }}
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            <span class="h5 text-primary mb-0">${{ number_format($product->price, 2) }}</span>
                                        </div>
                                        <div class="btn-group">
                                            @if($product->isAvailable())
                                                <form method="POST" action="{{ route('checkout.create', ['event' => $event->id, 'product' => $product->id]) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Buy Now">
                                                        <i class="bi bi-cart-plus"></i> Buy
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="bi bi-cart-x"></i> Out of Stock
                                                </button>
                                            @endif
                                            <a href="{{ route('products.edit', ['event' => $event->id, 'product' => $product->id]) }}" 
                                               class="btn btn-outline-primary btn-sm" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-outline-danger btn-sm delete-product" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Delete"
                                                    data-product-id="{{ $product->id }}"
                                                    data-product-name="{{ $product->name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Products pagination">
                            {{ $products->links() }}
                        </nav>
                    </div>
                @endif
            @endif
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
                <p>Are you sure you want to delete <strong id="productNameToDelete"></strong>?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteProductForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
@include('client.layouts.footer')

@push('styles')
<style>
    .product-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border: none;
        border-radius: 12px;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        width: 30px;
        height: 30px;
        background: rgba(0,0,0,0.5);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        margin: 0 10px;
    }
    
    .card-img-top {
        border-radius: 12px 12px 0 0;
        overflow: hidden;
    }
    
    /* Style for the form button to match other buttons */
    .btn-group form {
        display: inline-block;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-K6YShuO0pj+lY+z+U/+oD/y7TRsExSvHLkO/9xY3xHqPb+2Xikq0z+S+lfJ9zv2t" crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - initializing scripts');

        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Delete product functionality
        const deleteButtons = document.querySelectorAll('.delete-product');
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
        const productNameElement = document.getElementById('productNameToDelete');
        const deleteForm = document.getElementById('deleteProductForm');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                
                productNameElement.textContent = productName;
                deleteForm.action = `/events/{{ $event->id }}/products/${productId}`;
                deleteModal.show();
            });
        });
    });
</script>
@endpush