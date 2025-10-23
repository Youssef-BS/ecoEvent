<!DOCTYPE html>
<html lang="en">

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

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->

    @include('client.layouts.navbar')

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-4">
            <h1 class="display-3 animated slideInDown">Event Details</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event') }}">Events</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container py-5">
        <div class="event-item p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">{{ $event->title }}</h2>
                <div>
                    @auth
                    @if (auth()->id() === (int) $event->user_id)
                    <a href="{{ route('events.edit', $event) }}" class="btn btn-warning py-1 px-3">Edit</a>
                    <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Delete this event?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger py-1 px-3" type="submit">Delete</button>
                    </form>
                    @endif
                    @endauth
                    <a href="{{ route('event') }}" class="btn btn-secondary py-1 px-3">All events</a>
                </div>
            </div>

            <div class="row g-4 align-items-start">
                <div class="col-md-6">
                    @if ($event->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->image))
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($event->image) }}"
                        alt="{{ $event->title }}" class="img-fluid w-100 rounded mb-3">
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="bg-light p-4 rounded mb-3">
                        <p class="mb-0"><span class="badge bg-primary">{{ $event->categories }}</span> &nbsp;
                        <p class="mb-2"><i
                                class="fa fa-calendar-alt text-primary me-2"></i>{{ $event->date?->format('M d, Y H:i') }}
                        </p>
                        <p class="mb-2"><i
                                class="fa fa-map-marker-alt text-primary me-2"></i>{{ $event->location ?? '—' }}</p>
                        @php $price = is_null($event->price) ? 0 : (int) $event->price; @endphp

                        <strong>Price:</strong>
                        {{ $price === 0 ? 'Free' : number_format($price, 0, ',', ' ') . ' DT' }}
                        </p>
                    </div>
                    <p class="mb-3 text-break"
                        style="white-space: pre-wrap; overflow-wrap: anywhere; word-break: break-word;">
                        {{ $event->description }}
                    </p>
                    <p class="text-muted mb-0">Created by: {{ $event->user?->first_name }}
                        {{ $event->user?->last_name }}
                    </p>
                </div>

                <!-- Bouton pour ouvrir la modal -->
                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                    Give Feedback on Resources
                </button>

            </div>
        </div>
        <a href="{{ route('products.index', $event) }}" class="btn btn-primary mt-2 text-secondary rouded-3">
            View Products for sale for this event
        </a>
    </div>


    @includeIf('client.layouts.footer')

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>
    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- Feedback Modal -->
    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('feedbacks.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="feedbackModalLabel">Resources & Feedback</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        @if($event->resources->count() > 0)
                        <div class="row g-4">
                            @foreach($event->resources as $resource)
                            <div class="col-md-4 text-center">
                                <div class="card shadow-sm border-0">
                                    @if ($resource->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($resource->image))
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($resource->image) }}"
                                        alt="{{ $resource->name }}"
                                        class="card-img-top rounded-top"
                                        style="height: 150px; object-fit: cover;">
                                    @else
                                    <img src="{{ asset('img/default-resource.jpg') }}"
                                        alt="No image"
                                        class="card-img-top rounded-top"
                                        style="height: 150px; object-fit: cover;">
                                    @endif

                                    <div class="card-body">
                                        <h6 class="card-title">{{ $resource->name }}</h6>
                                        <p class="text-muted mb-1">Sponsor: <strong>{{ $resource->sponsor->name }}</strong></p>

                                        <div class="star-rating mb-2" data-resource="{{ $resource->id }}">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa-regular fa-star" data-value="{{ $i }}"></i>
                                                @endfor
                                        </div>

                                        <input type="hidden" name="ratings[{{ $resource->id }}]" value="0">
                                        <input type="hidden" name="sponsor_ids[{{ $resource->id }}]" value="{{ $resource->sponsor->id }}">
                                        <input type="hidden" name="resource_ids[]" value="{{ $resource->id }}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <label for="comment" class="form-label">Global Comment</label>
                            <textarea name="comment" id="comment" rows="3" class="form-control"></textarea>
                        </div>
                        @else
                        <p>No resources associated with this event.</p>
                        @endif
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.star-rating').forEach(container => {
                const stars = container.querySelectorAll('.fa-star');
                const input = container.nextElementSibling; // le input hidden correspondant
                stars.forEach(star => {
                    star.addEventListener('click', () => {
                        const rating = star.getAttribute('data-value');
                        input.value = rating;

                        stars.forEach(s => {
                            s.classList.remove('fa-solid', 'text-warning');
                            s.classList.add('fa-regular');
                        });

                        for (let i = 0; i < rating; i++) {
                            stars[i].classList.remove('fa-regular');
                            stars[i].classList.add('fa-solid', 'text-warning');
                        }
                    });
                });
            });
        });
    </script>

</body>

</html>