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
    <style>
        /* Reviews section styling */
        .reviews-card {
            border-radius: 1rem;
        }

        .reviews-header {
            border-bottom: 1px solid rgba(0, 0, 0, .06);
        }

        .rating-pill {
            background: #eef6d1;
            /* subtle green */
            color: #0d1b2a;
            border: 1px solid rgba(13, 27, 42, .15);
            border-radius: 999px;
            padding: .35rem .7rem;
            font-weight: 700;
        }

        /* Star rating input */
        .star-rating {
            direction: rtl;
            display: inline-flex;
            gap: .15rem;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            cursor: pointer;
            font-size: 1.25rem;
            color: #d4d8dd;
            transition: color .15s ease;
        }

        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #ffc107;
        }

        .review-item+.review-item {
            border-top: 1px solid rgba(0, 0, 0, .06);
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #0d1b2a;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
    </style>
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
                    @if ($event->has_image)
                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}"
                            class="img-fluid w-100 rounded mb-3">
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

                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <span><strong>Price:</strong>
                                {{ $price === 0 ? 'Free' : number_format($price, 0, ',', ' ') . ' DT' }}</span>
                            {{-- <span class="badge"
                                style="background:#CBDF72;color:#0d1b2a;border:1px solid rgba(13,27,42,.15);border-radius:999px;padding:.45rem .85rem;"
                                title="Participants">
                                {{ $event->participants()->count() }}
                            </span> --}}
                        </div>
                        </p>
                    </div>
                    <p class="mb-3 text-break"
                        style="white-space: pre-wrap; overflow-wrap: anywhere; word-break: break-word;">
                        {{ $event->description }}
                    </p>
                    <p class="text-muted mb-0">Created by: {{ $event->user?->first_name }}
                        {{ $event->user?->last_name }}</p>

                    @auth
                        @php
                            $alreadyJoined = $event
                                ->participants()
                                ->where('users.id', auth()->id())
                                ->exists();
                        @endphp
                        <div class="mt-3 d-flex gap-2">
                            @if (!$alreadyJoined)
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#registerModal">Register</button>
                            @else
                                <form action="{{ route('participations.destroy', $event) }}" method="POST"
                                    onsubmit="return confirm('Unregister from this event?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger" type="submit">Unregister</button>
                                </form>
                            @endif
                        </div>
                    @else
                        <a class="btn btn-primary mt-3" href="{{ route('login') }}">Login to Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    @auth
        <!-- Register Modal -->
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Register to {{ $event->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('participations.store', $event) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0 small">
                                        @foreach ($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Full name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', auth()->user()->first_name . ' ' . auth()->user()->last_name) }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', auth()->user()->email) }}" required>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Phone (optional)</label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ old('phone', auth()->user()->phone) }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth

    <!-- Reviews Section -->
    <div class="container pb-5">
        <div class="bg-white shadow-sm reviews-card">
            <div class="p-4 d-flex justify-content-between align-items-center reviews-header">
                <h3 class="h4 mb-0">Reviews</h3>
                @php $reviewsCount = $event->reviews->count(); @endphp
                <div class="d-flex align-items-center gap-2">
                    @if (!is_null($averageRating))
                        <span class="rating-pill">{{ $averageRating }} / 5</span>
                        <span class="text-warning">
                            @for ($s = 1; $s <= 5; $s++)
                                <i class="fa fa-star{{ $s <= round($averageRating) ? '' : '-o' }}"></i>
                            @endfor
                        </span>
                    @endif
                    <span class="text-muted small">{{ $reviewsCount }} review{{ $reviewsCount == 1 ? '' : 's' }}</span>
                </div>
            </div>

            @auth
                @php
                    $alreadyReviewed = $event->reviews->firstWhere('user_id', auth()->id());
                @endphp
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (!$alreadyReviewed)
                    <form action="{{ route('reviews.store', $event) }}" method="POST" class="p-3 p-md-4">
                        @csrf
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="form-label d-block">Rating <span class="text-danger">*</span></label>
                                <div class="star-rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="rate_{{ $i }}" name="rating"
                                            value="{{ $i }}" required>
                                        <label for="rate_{{ $i }}"
                                            aria-label="{{ $i }} star{{ $i > 1 ? 's' : '' }}"><i
                                                class="fa fa-star"></i></label>
                                    @endfor
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Comment (optional)</label>
                                <textarea name="comment" rows="2" class="form-control" placeholder="Share your thoughts"></textarea>
                            </div>
                            <div class="col-md-2 d-grid">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="alert alert-info m-4">You have already reviewed this event. You can edit or delete your
                        review below.</div>
                @endif
            @endauth

            <div class="list-group list-group-flush">
                @forelse($event->reviews as $review)
                    <div class="list-group-item review-item py-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-start gap-3">
                                @php
                                    $fn = $review->user?->first_name ?? '';
                                    $ln = $review->user?->last_name ?? '';
                                    $initials = strtoupper(mb_substr($fn, 0, 1) . mb_substr($ln, 0, 1));
                                @endphp
                                <div class="avatar-circle">{{ $initials }}</div>
                                <div>
                                    <div class="fw-semibold">{{ $fn }} {{ $ln }}</div>
                                    <div class="text-warning small">
                                        @for ($s = 1; $s <= 5; $s++)
                                            <i class="fa fa-star{{ $s <= $review->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted">{{ $review->created_at?->diffForHumans() }}</small>
                        </div>
                        @if ($review->comment)
                            <p class="mt-2 mb-0 text-break" style="white-space:pre-wrap;">{{ $review->comment }}</p>
                        @endif
                        @auth
                            @if (auth()->id() === (int) $review->user_id)
                                <div class="d-flex gap-2">
                                    <!-- Edit inline collapsible -->
                                    <button class="btn btn-sm btn-outline-secondary" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#editReview{{ $review->idReview }}">Edit</button>
                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                                        onsubmit="return confirm('Delete this review?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                                <div id="editReview{{ $review->idReview }}" class="collapse mt-3">
                                    <form action="{{ route('reviews.update', $review) }}" method="POST"
                                        class="border rounded p-3 bg-light">
                                        @csrf
                                        @method('PUT')
                                        <div class="row g-2 align-items-center">
                                            <div class="col-sm-4">
                                                <label class="form-label d-block">Rating</label>
                                                <div class="star-rating">
                                                    @for ($i = 5; $i >= 1; $i--)
                                                        <input type="radio"
                                                            id="edit_rate_{{ $review->idReview }}_{{ $i }}"
                                                            name="rating" value="{{ $i }}"
                                                            @checked($i == $review->rating) required>
                                                        <label
                                                            for="edit_rate_{{ $review->idReview }}_{{ $i }}"><i
                                                                class="fa fa-star"></i></label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">Comment</label>
                                                <textarea name="comment" rows="2" class="form-control">{{ $review->comment }}</textarea>
                                            </div>
                                            <div class="col-sm-2 d-grid">
                                                <button class="btn btn-primary" type="submit">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                @empty
                    <p class="text-muted mb-0 p-4">No reviews yet. Be the first to share your feedback!</p>
                @endforelse
            </div>
        </div>
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
