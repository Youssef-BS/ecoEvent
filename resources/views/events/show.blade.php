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
                        {{ $event->user?->last_name }}</p>
                </div>


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
</body>

</html>
