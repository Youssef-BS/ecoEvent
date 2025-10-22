<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Charitize - Charity Organization Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
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
        /* Floating card effect */
        .event-card {
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
            will-change: transform;
        }

        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12) !important;
            border-color: rgba(0, 0, 0, 0.08) !important;
        }

        .event-card .position-relative img {
            transition: transform .35s ease;
        }

        .event-card:hover .position-relative img {
            transform: scale(1.03);
        }

        /* Two-button pagination styling */
        .pagination .page-item .page-link {
            border-radius: .75rem;
            padding: .6rem 1rem;
            border: 2px solid #0d1b2a26;
            /* subtle */
            color: #0d1b2a;
            background: #fff;
            box-shadow: 0 1px 0 rgba(13, 27, 42, .04);
        }

        .pagination .page-item .page-link:hover {
            background: #f8f9fb;
            border-color: #0d1b2a3a;
            text-decoration: none;
        }

        .pagination .page-item.active .page-link,
        .pagination .page-item.disabled .page-link {
            border-color: #0d1b2a3a;
        }

        /* Prominent price badge */
        .price-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            z-index: 3;
            border-radius: 999px;
            padding: .4rem .85rem;
            font-weight: 700;
            font-size: .92rem;
            color: #0d1b2a;
            /* dark for contrast on light badge */
            letter-spacing: .2px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.18);
            border: 1px solid rgba(13, 27, 42, .15);
            background: #CBDF72;
            /* requested color */
            user-select: none;
        }

        .price-badge.is-free {
            background: #CBDF72;
        }

        .price-badge.is-paid {
            background: #CBDF72;
        }

        /* Participants badge (right side) with same styling */
        .participants-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 3;
            border-radius: 999px;
            padding: .4rem .85rem;
            font-weight: 700;
            font-size: .92rem;
            color: #0d1b2a;
            background: #CBDF72;
            border: 1px solid rgba(13, 27, 42, .15);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.18);
            letter-spacing: .2px;
            user-select: none;
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


    <!-- Topbar Start -->
    @include('client.layouts.navbar')
    <!-- Topbar End -->


    <!-- Navbar Start -->

    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-4">
            <h1 class="display-3 animated slideInDown">Event</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#!">Home</a></li>
                    <li class="breadcrumb-item"><a href="#!">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Event</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Video Start -->
    <div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-0">
                <div class="col-lg-11">
                    <div class="h-100 py-5 d-flex align-items-center">
                        <button type="button" class="btn-play" data-bs-toggle="modal"
                            data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                            <span></span>
                        </button>
                        <h3 class="ms-5 mb-0">Together, we can build a world where nature and humanity thrive in
                            harmony.
                        </h3>
                    </div>
                </div>
                <div class="d-none d-lg-block col-lg-1">
                    <div class="h-100 w-100 bg-secondary d-flex align-items-center justify-content-center">
                        <span class="text-white" style="transform: rotate(-90deg);">Scroll Down</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video End -->


    <!-- Video Modal Start -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen
                            allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video Modal End -->


    <!-- Event Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-md-end align-items-center mb-4 gap-3">
                <div class="text-center text-md-start">
                    <p class="section-title bg-white text-primary px-3 d-inline-block">Events</p>
                    <h1 class="display-6 mb-0">Be a Part of a Global Movement</h1>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filtersModal"
                        id="filtersBtn">
                        <i class="bi bi-funnel"></i> Filters <span class="badge bg-primary ms-1 d-none"
                            id="filtersCount"></span>
                    </button>
                    @auth
                        <a href="{{ route('events.create') }}" class="btn btn-primary">Create Event</a>
                    @endauth
                </div>
            </div>

            <div id="events-grid">
                <div class="row g-4">
                    @foreach ($events ?? [] as $event)
                        <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                            <div
                                class="event-item event-card position-relative h-100 p-4 border rounded-3 shadow-sm bg-white">
                                @php
                                    $price = is_null($event->price) ? 0 : (int) $event->price;
                                    $priceText =
                                        $price > 0
                                            ? 'It starts with ' . number_format($price, 0, ',', ' ') . ' DT'
                                            : 'Free';
                                @endphp
                                <div class="price-badge {{ $price > 0 ? 'is-paid' : 'is-free' }}">{{ $priceText }}
                                </div>
                                <div class="participants-badge" title="Participants">
                                    {{ $event->participants_count ?? 0 }} IN
                                </div>
                                @if ($event->has_image)
                                    <div class="position-relative mb-4">
                                        <img class="img-fluid w-100" src="{{ $event->image_url }}"
                                            alt="{{ $event->title }}">
                                    </div>
                                @endif
                                <a href="{{ route('events.show', $event) }}"
                                    class="h3 d-inline-block text-break stretched-link">{{ $event->title }}</a>
                                <p class="text-break mb-3"
                                    style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 220) }}</p>
                                <div class="bg-light p-4">
                                    <p class="mb-1"><i
                                            class="fa fa-clock text-primary me-2"></i>{{ optional($event->date)->format('h:i A') }}
                                    </p>
                                    <p class="mb-1"><i
                                            class="fa fa-calendar-alt text-primary me-2"></i>{{ optional($event->date)->format('M d, Y') }}
                                    </p>
                                    <p class="mb-0"><i
                                            class="fa fa-map-marker-alt text-primary me-2"></i>{{ $event->location ?? '—' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if (($events ?? null) instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="d-flex justify-content-center mt-4">
                        {{ $events->onEachSide(2)->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Event End -->

    <!-- Filters Modal -->
    <div class="modal fade" id="filtersModal" tabindex="-1" aria-labelledby="filtersModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filtersModalLabel">Filters</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="GET" id="filtersForm">
                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Location (City)</label>
                                <input type="text" name="location" class="form-control"
                                    value="{{ request('location') }}" placeholder="e.g. Sfax">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Price</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="freeCheck"
                                        name="free" @checked(request('free') == '1')>
                                    <label class="form-check-label" for="freeCheck">Free</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Categories</label>
                                <div class="row">
                                    @php
                                        // Use configured categories (with emojis) to ensure filter values match DB
                                        $allCategories = config('events.categories', []);
                                        $selectedCats = (array) request('categories');
                                    @endphp
                                    @foreach ($allCategories as $cat)
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="categories[]"
                                                    value="{{ $cat }}" id="cat_{{ md5($cat) }}"
                                                    @checked(in_array($cat, $selectedCats))>
                                                <label class="form-check-label"
                                                    for="cat_{{ md5($cat) }}">{{ $cat }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold d-block">Date</label>
                                @php $dr = request('date_range'); @endphp
                                <div class="row g-2 small">
                                    @foreach ([
        'tomorrow' => 'Tomorrow',
        'weekend' => 'This weekend',
        'this_week' => 'This week',
        'next_week' => 'Next week',
        'this_month' => 'This month',
        'next_month' => 'Next month',
    ] as $val => $label)
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="date_range"
                                                    id="dr_{{ $val }}" value="{{ $val }}"
                                                    @checked($dr === $val)>
                                                <label class="form-check-label"
                                                    for="dr_{{ $val }}">{{ $label }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="date_range"
                                                id="dr_any" value="" @checked(!$dr)>
                                            <label class="form-check-label" for="dr_any">Any time</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" id="resetFiltersBtn">Reset
                            All</button>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Banner Start -->
    <div class="container-fluid banner py-5">
        <div class="container">
            <div class="banner-inner bg-light p-5 wow fadeIn" data-wow-delay="0.1s">
                <div class="row justify-content-center">
                    <div class="col-lg-8 py-5 text-center">
                        <h1 class="display-6 wow fadeIn" data-wow-delay="0.3s">Our Door Are Always Open to More People
                            Who Want to Support Each Others!</h1>
                        <p class="fs-5 mb-4 wow fadeIn" data-wow-delay="0.5s">Through your donations and volunteer
                            work,
                            we spread kindness and support to children, families, and communities struggling to find
                            stability.</p>
                        <div class="d-flex justify-content-center wow fadeIn" data-wow-delay="0.7s">
                            <a class="btn btn-primary py-3 px-4 me-3" href="#!">Donate Now</a>
                            <a class="btn btn-secondary py-3 px-4" href="#!">Join Us Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->


    <!-- Newsletter Start -->
    <div class="container-fluid bg-primary py-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-6 mb-4">Subscribe the Newsletter</h1>
                    <div class="position-relative w-100 mb-2">
                        <input class="form-control border-0 w-100 ps-4 pe-5" type="text"
                            placeholder="Enter Your Email" style="height: 60px;">
                        <button type="button"
                            class="btn btn-lg-square shadow-none position-absolute top-0 end-0 mt-2 me-2"><i
                                class="fa fa-paper-plane text-primary fs-4"></i></button>
                    </div>
                    <p class="mb-0">Don't worry, we won't spam you with emails.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Newsletter End -->


    <!-- Footer Start -->
    <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-5 py-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Our Office</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-3">
                        <a class="btn btn-square btn-primary me-2" href="#!"><i
                                class="fab fa-x-twitter"></i></a>
                        <a class="btn btn-square btn-primary me-2" href="#!"><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-primary me-2" href="#!"><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-primary me-2" href="#!"><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="#!">About Us</a>
                    <a class="btn btn-link" href="#!">Contact Us</a>
                    <a class="btn btn-link" href="#!">Our Services</a>
                    <a class="btn btn-link" href="#!">Terms & Condition</a>
                    <a class="btn btn-link" href="#!">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Business Hours</h4>
                    <p class="mb-1">Monday - Friday</p>
                    <h6 class="text-light">09:00 am - 07:00 pm</h6>
                    <p class="mb-1">Saturday</p>
                    <h6 class="text-light">09:00 am - 12:00 pm</h6>
                    <p class="mb-1">Sunday</p>
                    <h6 class="text-light">Closed</h6>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Gallery</h4>
                    <div class="row g-2">
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-1.jpg') }}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-2.jpg') }}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-3.jpg') }}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-4.jpg') }}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-5.jpg') }}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-6.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright pt-5">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="fw-semi-bold" href="#!">Your Site Name</a>, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                        <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                        Designed By <a class="fw-semi-bold" href="https://htmlcodex.com">HTML Codex</a>. Distributed
                        by
                        <a class="fw-semi-bold" href="https://themewagon.com">ThemeWagon</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#!" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


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
    <script>
        // AJAX pagination: replace only the events grid, not the whole page
        function wireEventsPagination(root) {
            const scope = root || document;
            scope.querySelectorAll('.pagination a.page-link').forEach(a => {
                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');
                    if (!url) return;
                    fetch(url)
                        .then(r => r.text())
                        .then(html => {
                            const tmp = document.createElement('div');
                            tmp.innerHTML = html;
                            const fresh = tmp.querySelector('#events-grid');
                            const current = document.querySelector('#events-grid');
                            if (fresh && current) {
                                current.replaceWith(fresh);
                                wireEventsPagination(fresh);
                                window.history.pushState({}, '', url);
                                fresh.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }
                        })
                        .catch(console.error);
                });
            });
        }

        function updateFiltersBadge() {
            const params = new URLSearchParams(window.location.search);
            let count = 0;
            if (params.get('location')) count++;
            if (params.getAll('categories[]').length) count++;
            if (params.get('date_range')) count++;
            if (params.get('free') === '1') count++;
            const badge = document.getElementById('filtersCount');
            if (!badge) return;
            if (count) {
                badge.textContent = count;
                badge.classList.remove('d-none');
            } else {
                badge.classList.add('d-none');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            wireEventsPagination();
            updateFiltersBadge();
            const form = document.getElementById('filtersForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Allow normal GET submit but keep pagination replacement after load
                    // Append page reset
                    const pageInput = form.querySelector('input[name="page"]');
                    if (pageInput) pageInput.remove();
                });
            }
            const resetBtn = document.getElementById('resetFiltersBtn');
            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    const url = window.location.pathname; // clear query
                    window.location.href = url; // full reload resets filters
                });
            }
        });

        // Handle browser back/forward to keep the grid in sync
        window.addEventListener('popstate', () => {
            fetch(location.href)
                .then(r => r.text())
                .then(html => {
                    const tmp = document.createElement('div');
                    tmp.innerHTML = html;
                    const fresh = tmp.querySelector('#events-grid');
                    const current = document.querySelector('#events-grid');
                    if (fresh && current) {
                        current.replaceWith(fresh);
                        wireEventsPagination(fresh);
                        updateFiltersBadge();
                    }
                })
                .catch(console.error);
        });
    </script>
</body>

</html>
