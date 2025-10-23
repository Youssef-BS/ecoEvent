<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Select Resources - Charitize</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- CSS & Fonts -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        .resource-card {
            position: relative;
            padding: 10px;
            margin-bottom: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
            text-align: center;
            overflow: hidden;
            transition: 0.2s;
        }

        .resource-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
        }

        .resource-card img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 0 0 10px 10px;
            margin-top: 10px;
        }

        .resource-radio {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.9);
            padding: 4px;
            border-radius: 50%;
            border: 1px solid #ddd;
            z-index: 10;
        }

        .resource-radio input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .quantity-input {
            display: flex;
            margin-top: 8px;
            justify-content: center;
            gap: 6px;
            align-items: center;
        }

        .quantity-input.hidden {
            display: none;
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
            font-size: 0.9rem;
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    @include('client.layouts.navbar')

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
                            <input type="checkbox" class="resource-select" data-resource-id="{{ $resource->id }}"
                                {{ $existingQty > 0 ? 'checked' : '' }}>
                        </div>

                        @if($resource->image)
                        <img src="{{ asset('storage/'.$resource->image) }}" alt="{{ $resource->title }}">
                        @endif

                        <h5>{{ $resource->title }}</h5>
                        <p><strong>Sponsor:</strong> {{ $resource->sponsor->name ?? '-' }}</p>
                        <p><strong>Available:</strong> {{ $available }}</p>

                        <div class="quantity-input {{ $existingQty > 0 ? '' : 'hidden' }}" id="quantity-{{ $resource->id }}">
                            <label>Quantity to Reserve:</label>
                            <input type="number" name="quantities[{{ $resource->id }}]"
                                min="0" max="{{ $available }}" value="{{ $existingQty }}">
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
        document.querySelectorAll('.resource-select').forEach(checkbox => {
            const resourceId = checkbox.dataset.resourceId;
            const quantityDiv = document.getElementById('quantity-' + resourceId);

            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    quantityDiv.classList.remove('hidden');
                    const input = quantityDiv.querySelector('input');
                    if (parseInt(input.value) < 1) input.value = 1;
                } else {
                    quantityDiv.classList.add('hidden');
                    quantityDiv.querySelector('input').value = 0;
                }
            });
        });
    </script>
</body>

</html>