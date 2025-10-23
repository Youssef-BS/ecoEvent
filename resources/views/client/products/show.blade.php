@include('client.layouts.navbar')
<head>
    <meta charset="utf-8">
    <title>Product Details - Charitize</title>
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

<body>
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index', $event) }}">{{ $event->name }} Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6">
            @if($product->images->count() > 0)
                <!-- Main Image -->
                <div class="mb-3 text-center">
                    <img id="mainImage" src="{{ Storage::disk('public')->url($product->images->first()->path) }}" 
                         alt="{{ $product->name }}" class="img-fluid rounded shadow-sm" 
                         style="max-height: 400px; width: 100%; object-fit: cover;">
                </div>

                <!-- Thumbnail Gallery -->
                @if($product->images->count() > 1)
                    <div class="row g-2 justify-content-center">
                        @foreach($product->images as $image)
                            <div class="col-auto">
                                <img src="{{ Storage::disk('public')->url($image->path) }}"
                                     alt="{{ $product->name }}"
                                     class="img-thumbnail thumbnail-image cursor-pointer"
                                     style="width: 80px; height: 80px; object-fit: cover;"
                                     onclick="changeMainImage('{{ Storage::disk('public')->url($image->path) }}')">
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="text-center py-5 bg-light rounded">
                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No images available</p>
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title h3 mb-3">{{ $product->name }}</h1>
                    
                    <div class="mb-3">
                        <span class="h4 text-primary fw-bold">${{ number_format($product->price, 2) }}</span>
                    </div>

                    <div class="mb-3">
                        <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }} fs-6">
                            {{ $product->quantity > 0 ? $product->quantity . ' in stock' : 'Out of stock' }}
                        </span>
                    </div>

                    @if($product->description)
                        <div class="mb-4">
                            <h5 class="text-muted mb-2">Description</h5>
                            <p class="card-text text-dark">{{ $product->description }}</p>
                        </div>
                    @endif

                    <div class="mb-4 p-3 bg-light rounded">
                        <h5 class="text-muted mb-3">Event Information</h5>
                        <p class="mb-2"><strong>Event:</strong> {{ $event->name }}</p>
                        <p class="mb-0"><strong>Date:</strong> {{ $event->date->format('F j, Y') }}</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <a href="{{ route('products.edit', [$event, $product]) }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit me-1"></i> Edit Product
                        </a>
                        
                        <form action="{{ route('products.destroy', [$event, $product]) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-trash me-1"></i> Delete
                            </button>
                        </form>

                        <a href="{{ route('products.index', $event) }}" 
                           class="btn btn-outline-secondary btn-sm ms-auto">
                            <i class="fas fa-arrow-left me-1"></i> Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('client.layouts.footer')

<!-- JavaScript for Image Gallery -->
<script>
function changeMainImage(imageUrl) {
    document.getElementById('mainImage').src = imageUrl;
    
    // Update active thumbnail
    const thumbnails = document.querySelectorAll('.thumbnail-image');
    thumbnails.forEach(thumb => {
        thumb.classList.remove('active-thumbnail');
        if (thumb.src === imageUrl) {
            thumb.classList.add('active-thumbnail');
        }
    });
}

// Add hover effect to thumbnails
document.addEventListener('DOMContentLoaded', function() {
    const thumbnails = document.querySelectorAll('.thumbnail-image');
    thumbnails.forEach(thumb => {
        thumb.addEventListener('mouseenter', function() {
            this.style.opacity = '0.7';
            this.style.transform = 'scale(1.05)';
        });
        thumb.addEventListener('mouseleave', function() {
            if (!this.classList.contains('active-thumbnail')) {
                this.style.opacity = '1';
                this.style.transform = 'scale(1)';
            }
        });
    });
    
    // Set first thumbnail as active initially
    if (thumbnails.length > 0) {
        thumbnails[0].classList.add('active-thumbnail');
    }
});
</script>

<style>
.thumbnail-image {
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid #dee2e6;
}

.thumbnail-image:hover {
    transform: scale(1.05);
    border-color: #007bff !important;
}

.active-thumbnail {
    border-color: #007bff !important;
    transform: scale(1.05);
}

.cursor-pointer {
    cursor: pointer;
}

.card {
    border: none;
    border-radius: 10px;
}

.img-thumbnail {
    border-radius: 8px;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.btn {
    border-radius: 6px;
}

.breadcrumb {
    background-color: transparent;
    padding: 0;
}

.breadcrumb-item a {
    text-decoration: none;
    color: #6c757d;
}

.breadcrumb-item a:hover {
    color: #007bff;
}
</style>
</body>
</html>