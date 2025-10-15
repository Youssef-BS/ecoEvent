<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Select Resources - Charitize</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600;700&family=Open+Sans&display=swap"
        rel="stylesheet">

    <!-- Icon Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries & CSS -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        /* ------------------- SMALLER RESOURCE CARD ------------------- */
        .resource-card {
            position: relative;
            padding: 10px 10px 0 10px;
            margin-bottom: 20px;
            background: #ffffff;
            /* white card for readability */
            border: none;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            text-align: center;
            overflow: hidden;
        }

        .resource-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
        }

        /* ------------------- IMAGE ------------------- */
        .resource-card img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 0 0 10px 10px;
            display: block;
            margin-top: 10px;
        }

        /* ------------------- CHECKBOX ------------------- */
        .resource-radio {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
            background: rgba(255, 255, 255, 0.9);
            padding: 4px;
            border-radius: 50%;
            border: 1px solid #ddd;
        }

        .resource-radio input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        /* ------------------- CONTENT ------------------- */
        .resource-card h5 {
            font-weight: 700;
            color: #000;
            margin-bottom: 4px;
            font-size: 1rem;
        }

        .resource-card p {
            color: #555;
            font-size: 0.9rem;
            line-height: 1.3;
            margin-bottom: 3px;
        }

        .resource-card strong {
            color: #0d6efd;
        }

        /* ------------------- QUANTITY INPUT ------------------- */
        .quantity-input {
            display: none;
            margin-top: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }

        .quantity-input input {
            width: 60px;
            text-align: center;
            border-radius: 6px;
            border: 1px solid #ccc;
            padding: 3px 6px;
        }

        .quantity-input label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    @include('client.layouts.navbar')

    <!-- Page Header -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-4">
            <h1 class="display-3 animated slideInDown">Select Resources</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event') }}">Events</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Resource</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container py-5">
        <h2 class="mb-4">For Event: <strong>{{ $event->title }}</strong></h2>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('events.resources.update', $event->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                @foreach($resources as $resource)
                @php
                $existingQty = $existing[$resource->id] ?? 0;
                $available = $resource->quantity + $existingQty;
                @endphp
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card resource-card">
                        <div class="resource-radio">
                            <input type="checkbox" class="resource-select" data-resource-id="{{ $resource->id }}">
                        </div>
                        @if($resource->image)
                        <img src="{{ asset('storage/'.$resource->image) }}" alt="{{ $resource->title }}">
                        @endif
                        <h5 class="mt-2">{{ $resource->title }}</h5>
                        <p><strong>Sponsor:</strong> {{ $resource->sponsor->name ?? '-' }}</p>
                        <p><strong>Available:</strong> {{ $available }}</p>

                        <div class="quantity-input" id="quantity-{{ $resource->id }}">
                            <label>Quantity to Reserve:</label>
                            <input type="number" name="quantities[{{ $resource->id }}]" min="1"
                                max="{{ $available }}" value="{{ $existingQty }}">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('events.show', $event->id) }}" class="btn btn-secondary me-2">Skip / Finish</a>
                <button class="btn btn-primary">Save Resource</button>
            </div>
        </form>
    </div>

    <script>
        // Show/hide quantity input when checkbox is toggled
        document.querySelectorAll('.resource-select').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const resourceId = this.dataset.resourceId;
                const quantityDiv = document.getElementById('quantity-' + resourceId);

                if (this.checked) {
                    quantityDiv.style.display = 'flex';
                } else {
                    quantityDiv.style.display = 'none';
                    quantityDiv.querySelector('input').value = 0;
                }
            });
        });
    </script>
</body>

</html>