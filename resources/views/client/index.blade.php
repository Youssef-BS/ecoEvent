<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Charitize - Charity Organization Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600;700&family=Open+Sans&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>

    @include('client.layouts.navbar')

    <div class="container-fluid p-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="owl-carousel header-carousel py-5">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="carousel-text">
                            <h1 class="display-1 text-uppercase mb-3">Together for a Better Tomorrow</h1>
                            <p class="fs-5 mb-5">We believe in creating opportunities and empowering communities through
                                education, healthcare, and sustainable development.</p>
                            <div class="d-flex">
                                <a class="btn btn-primary py-3 px-4 me-3" href="#!">Donate Now</a>
                                <a class="btn btn-secondary py-3 px-4" href="#!">Join Us Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="carousel-img">
                            <img class="w-100" src="img/carousel-1.jpg" alt="Image">
                        </div>
                    </div>
                </div>
            </div>
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="carousel-text">
                            <h1 class="display-1 text-uppercase mb-3">Together, We Can Protect Our Planet</h1>
                            <p class="fs-5 mb-5">No one should live without clean air, safe water, or a healthy planet.
                                Your support helps us bring hope, balance, and a brighter future to our Earth.</p>
                            <div class="d-flex mt-4">
                                <a class="btn btn-primary py-3 px-4 me-3" href="#!">Donate Now</a>
                                <a class="btn btn-secondary py-3 px-4" href="#!">Join Us Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="carousel-img">
                            <img class="w-100" src="img/carousel-2.jpg" alt="Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Video Start -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Nos Sponsors</h2>

        <div class="sponsor-slider-wrapper">
            <div class="sponsor-slider">
                @foreach (array_merge($sponsors->toArray(), $sponsors->toArray()) as $sponsor)
                    <div class="sponsor-item">
                        @if ($sponsor['logo'])
                            <img src="{{ asset('storage/' . $sponsor['logo']) }}" alt="{{ $sponsor['name'] }}"
                                class="img-fluid mb-2">
                        @else
                            <div class="no-logo">No Logo</div>
                        @endif
                        <p class="sponsor-name">{{ $sponsor['name'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        .sponsor-slider-wrapper {
            width: 100%;
            overflow: hidden;

            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            position: relative;
        }


        .sponsor-slider {
            display: flex;
            align-items: center;
            gap: 40px;

            width: max-content;
            animation: scrollSponsors 30s linear infinite;
        }

        .sponsor-item {
            width: 180px;
            height: 150px;
            flex-shrink: 0;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .sponsor-item img {
            max-height: 80px;
            max-width: 100%;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .sponsor-name {
            font-weight: 600;
            font-size: 14px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            max-width: 100%;
        }

        .no-logo {
            background: #6c757d;
            color: #fff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 80px;
            width: 100%;
            margin-bottom: 10px;
        }

        /* Animation fluide */
        @keyframes scrollSponsors {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }
    </style>


    <style>
        .sponsor-slider::-webkit-scrollbar {
            display: none;

        }

        .sponsor-slider {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

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


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.2s">
                    <div class="about-img">
                        <img class="img-fluid w-100" src="img/about.jpg" alt="Image">
                    </div>
                </div>
                <div class="col-lg-6">
                    <p class="section-title bg-white text-start text-primary pe-3">About Us</p>
                    <h1 class="display-6 mb-4 wow fadeIn" data-wow-delay="0.2s">Join Hands, Change the World</h1>
                    <p class="mb-4 wow fadeIn" data-wow-delay="0.3s">Every hand that nurtures the Earth brings us
                        closer to a greener,
                        kinder world. Be part of
                        a movement that protects nature and builds hope for generations to come.</p>
                    <div class="row g-4 pt-2">
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.4s">
                            <div class="h-100">
                                <h3>Our Mission</h3>
                                <p>Our mission is to inspire and equip communities to care for the Earth through
                                    education,
                                    resources, and sustainable action.</p>
                                <p class="text-dark"><i class="fa fa-check text-primary me-2"></i>No one should live
                                    without clean air or water.</p>
                                <p class="text-dark"><i class="fa fa-check text-primary me-2"></i>We spread awareness
                                    and care for our planet.</p>
                                <p class="text-dark mb-0"><i class="fa fa-check text-primary me-2"></i>Together, we
                                    can change the Earth’s future.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                            <div class="h-100 bg-primary p-4 text-center">
                                <p class="fs-5 text-dark">Through your donations, we help communities protect
                                    nature and build a sustainable future.</p>
                                <a class="btn btn-secondary py-2 px-4" href="#!">Donate Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->




    <!-- Features Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="rounded overflow-hidden">
                        <div class="row g-0">
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                <div class="text-center bg-primary py-5 px-4 h-100">
                                    <i class="fa fa-users fa-3x text-secondary mb-3"></i>
                                    <h1 class="display-5 mb-0" data-toggle="counter-up">500</h1>
                                    <span class="text-dark">Team Members</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <div class="text-center bg-secondary py-5 px-4 h-100">
                                    <i class="fa fa-award fa-3x text-primary mb-3"></i>
                                    <h1 class="display-5 text-white mb-0" data-toggle="counter-up">70</h1>
                                    <span class="text-white">Award Winning</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="text-center bg-secondary py-5 px-4 h-100">
                                    <i class="fa fa-list-check fa-3x text-primary mb-3"></i>
                                    <h1 class="display-5 text-white mb-0" data-toggle="counter-up">3000</h1>
                                    <span class="text-white">Total Projects</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                <div class="text-center bg-primary py-5 px-4 h-100">
                                    <i class="fa fa-comments fa-3x text-secondary mb-3"></i>
                                    <h1 class="display-5 mb-0" data-toggle="counter-up">7000</h1>
                                    <span class="text-dark">Client's Review</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <p class="section-title bg-white text-start text-primary pe-3">Why Us!</p>
                    <h1 class="display-6 mb-4 wow fadeIn" data-wow-delay="0.2s">Few Reasons Why People Choosing Us!
                    </h1>
                    <p class="mb-4 wow fadeIn" data-wow-delay="0.3s">We believe in building a world where people and
                        nature thrive together. Through education, conservation, and sustainable action, we empower
                        communities to care for the Earth. Your support helps us plant hope, protect life, and create a
                        lasting impact.</p>
                    <p class="text-dark wow fadeIn" data-wow-delay="0.4s"><i
                            class="fa fa-check text-primary me-2"></i>Growing Change, Together</p>
                    <p class="text-dark wow fadeIn" data-wow-delay="0.5s"><i
                            class="fa fa-check text-primary me-2"></i>Caring for the Earth, Caring for Us</p>
                    <p class="text-dark wow fadeIn" data-wow-delay="0.6s"><i
                            class="fa fa-check text-primary me-2"></i>A Sustainable Future Starts Now</p>
                    <div class="d-flex mt-4 wow fadeIn" data-wow-delay="0.7s">
                        <a class="btn btn-primary py-3 px-4 me-3" href="#!">Donate Now</a>
                        <a class="btn btn-secondary py-3 px-4" href="#!">Join Us Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->


    <!-- Donation Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">Donation</p>
                <h1 class="display-6 mb-4">Our Donation Causes Around the World</h1>
            </div>
            <div class="row g-4">
                @php
                    $delays = ['0.1s', '0.13s', '0.5s'];
                    $index = 0;
                @endphp
                @forelse($donations->take(3) as $donation)
                    <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="{{ $delays[$index] }}">
                        <div class="donation-item d-flex h-100 p-4">
                            <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                                <h6 class="mb-0">Raised</h6>
                                <span class="mb-2">${{ number_format($donation->reached, 2) }}</span>
                                <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                    @php
                                        $progress = ($donation->reached / $donation->amount) * 100;
                                        $progress = min($progress, 100);
                                    @endphp
                                    <div class="progress-bar w-100 bg-secondary" role="progressbar"
                                        aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                        <span class="fs-4">{{ number_format($progress, 0) }}%</span>
                                    </div>
                                </div>
                                <h6 class="mb-0">Goal</h6>
                                <span>${{ number_format($donation->amount, 2) }}</span>
                            </div>
                            <div class="donation-detail">
                                <div class="position-relative mb-4">
                                    @if ($donation->image)
                                        <img class="img-fluid w-100"
                                            src="{{ asset('storage/donations/' . $donation->image) }}"
                                            alt="{{ $donation->title }}" style="height: 200px; object-fit: cover;">
                                    @else
                                        <img class="img-fluid w-100" src="{{ asset('img/donation-1.jpg') }}"
                                            alt="{{ $donation->title }}" style="height: 200px; object-fit: cover;">
                                    @endif
                                </div>
                                <a href="#!" class="h3 d-inline-block">{{ $donation->title }}</a>
                                <p>{{ $donation->description }}</p>
                                <small class="text-muted mt-2"><i
                                        class="fa fa-users me-1"></i>{{ $donation->donor_count }} Donators</small>
                                <a href="#!" class="btn btn-primary w-100 py-3"><i
                                        class="fa fa-plus me-2"></i>Donate Now</a>
                            </div>
                        </div>
                    </div>
                    @php $index++; @endphp
                @empty
                    <!-- Fallback to static content if no donations exist -->
                    <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                        <div class="donation-item d-flex h-100 p-4">
                            <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                                <h6 class="mb-0">Raised</h6>
                                <span class="mb-2">$8000</span>
                                <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                    <div class="progress-bar w-100 bg-secondary" role="progressbar"
                                        aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                        <span class="fs-4">85%</span>
                                    </div>
                                </div>
                                <h6 class="mb-0">Goal</h6>
                                <span>$10000</span>
                            </div>
                            <div class="donation-detail">
                                <div class="position-relative mb-4">
                                    <img class="img-fluid w-100" src="img/donation-1.jpg" alt=""
                                        style="height: 200px; object-fit: cover;">
                                </div>
                                <a href="#!" class="h3 d-inline-block">Healthy Food</a>
                                <p>Through your donations and volunteer work, we spread kindness and support to
                                    children.</p>
                                <a href="#!" class="btn btn-primary w-100 py-3"><i
                                        class="fa fa-plus me-2"></i>Donate Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.13s">
                        <div class="donation-item d-flex h-100 p-4">
                            <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                                <h6 class="mb-0">Raised</h6>
                                <span class="mb-2">$8000</span>
                                <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                    <div class="progress-bar w-100 bg-secondary" role="progressbar"
                                        aria-valuenow="95" aria-valuemin="0" aria-valuemax="100">
                                        <span class="fs-4">95%</span>
                                    </div>
                                </div>
                                <h6 class="mb-0">Goal</h6>
                                <span>$10000</span>
                            </div>
                            <div class="donation-detail">
                                <div class="position-relative mb-4">
                                    <img class="img-fluid w-100" src="img/donation-2.jpg" alt=""
                                        style="height: 200px; object-fit: cover;">
                                </div>
                                <a href="#!" class="h3 d-inline-block">Water Treatment</a>
                                <p>Through your donations and volunteer work, we spread kindness and support to
                                    children.</p>
                                <a href="#!" class="btn btn-primary w-100 py-3"><i
                                        class="fa fa-plus me-2"></i>Donate Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                        <div class="donation-item d-flex h-100 p-4">
                            <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                                <h6 class="mb-0">Raised</h6>
                                <span class="mb-2">$8000</span>
                                <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                    <div class="progress-bar w-100 bg-secondary" role="progressbar"
                                        aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                        <span class="fs-4">75%</span>
                                    </div>
                                </div>
                                <h6 class="mb-0">Goal</h6>
                                <span>$10000</span>
                            </div>
                            <div class="donation-detail">
                                <div class="position-relative mb-4">
                                    <img class="img-fluid w-100" src="img/donation-3.jpg" alt=""
                                        style="height: 200px; object-fit: cover;">
                                </div>
                                <a href="#!" class="h3 d-inline-block">Education Support</a>
                                <p>Through your donations and volunteer work, we spread kindness and support to
                                    children.</p>
                                <a href="#!" class="btn btn-primary w-100 py-3"><i
                                        class="fa fa-plus me-2"></i>Donate Now</a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Donation End -->


    <!-- Banner Start -->
    <div class="container-fluid banner py-5">
        <div class="container">
            <div class="banner-inner bg-light p-5 wow fadeIn" data-wow-delay="0.1s">
                <div class="row justify-content-center">
                    <div class="col-lg-8 py-5 text-center">
                        <h1 class="display-6 wow fadeIn" data-wow-delay="0.3s">Our doors are always open to those who
                            care about
                            the Earth and want to make a difference together!</h1>
                        <p class="fs-5 mb-4 wow fadeIn" data-wow-delay="0.5s">Through your generosity and action, we
                            restore nature,
                            support communities, and create lasting change for a greener tomorrow.</p>
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


    <!-- Event Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">Events</p>
                <h1 class="display-6 mb-4">Be a Part of a Global Movement</h1>
            </div>

            @if (($events ?? collect())->isNotEmpty())
                <div class="row g-4">
                    @foreach ($events as $i => $event)
                        @php
                            $delayMap = ['0.1s', '0.3s', '0.5s'];
                            $delay = $delayMap[$i % 3];
                            $price = is_null($event->price) ? 0 : (int) $event->price;
                        @endphp
                        <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="{{ $delay }}">
                            <div class="event-item h-100 p-4 position-relative">
                                @if ($event->has_image)
                                    <img class="img-fluid w-100 mb-4" src="{{ $event->image_url }}"
                                        alt="{{ $event->title }}">
                                @endif
                                <a href="{{ route('events.show', $event) }}"
                                    class="h3 d-inline-block text-break">{{ $event->title }}</a>
                                <p class="text-break mb-3"
                                    style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 200) }}
                                </p>
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
                <div class="text-center mt-4">
                    <a href="{{ route('event') }}" class="btn btn-primary">See all events</a>
                </div>
            @else
                <div class="text-center">
                    <p class="text-muted mb-3">No events yet.</p>
                    <a href="{{ route('event') }}" class="btn btn-primary">Explore Events</a>
                </div>
            @endif
        </div>
    </div>
    <!-- Event End -->





    <!-- Team Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">Our Team</p>
                <h1 class="display-6 mb-4">Meet Our Dedicated Team Members</h1>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="team-item d-flex h-100 p-4">
                        <div class="team-detail pe-4">
                            <img class="img-fluid mb-4" src="img/team-1.jpg" alt="">
                            <h3>Adem Selmani</h3>
                            <span>Events and Reviews section</span>
                        </div>
                        <div class="team-social bg-light d-flex flex-column justify-content-center flex-shrink-0 p-4">
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-x-twitter"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="team-item d-flex h-100 p-4">
                        <div class="team-detail pe-4">
                            <img class="img-fluid mb-4" src="img/team-2.jpg" alt="">
                            <h3>Zeineb Maatalli </h3>
                            <span>Sponsors and Resources section</span>
                        </div>
                        <div class="team-social bg-light d-flex flex-column justify-content-center flex-shrink-0 p-4">
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-x-twitter"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="team-item d-flex h-100 p-4">
                        <div class="team-detail pe-4">
                            <img class="img-fluid mb-4" src="img/team-3.jpg" alt="">
                            <h3>Ezzdiin Bnz</h3>
                            <span>Posts and Comments section</span>
                        </div>
                        <div class="team-social bg-light d-flex flex-column justify-content-center flex-shrink-0 p-4">
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-x-twitter"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="team-item d-flex h-100 p-4">
                        <div class="team-detail pe-4">
                            <img class="img-fluid mb-4" src="img/team-4.jpg" alt="">
                            <h3>Taher Mabrouk</h3>
                            <span>Notifications and Messageries section</span>
                        </div>
                        <div class="team-social bg-light d-flex flex-column justify-content-center flex-shrink-0 p-4">
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-x-twitter"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                    <div class="team-item d-flex h-100 p-4">
                        <div class="team-detail pe-4">
                            <img class="img-fluid mb-4" src="img/team-5.jpg" alt="">
                            <h3>Oussema khemiri</h3>
                            <span>Donations and Reclamations section</span>
                        </div>
                        <div class="team-social bg-light d-flex flex-column justify-content-center flex-shrink-0 p-4">
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-x-twitter"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="team-item d-flex h-100 p-4">
                        <div class="team-detail pe-4">
                            <img class="img-fluid mb-4" src="img/team-6.jpg" alt="">
                            <h3>Youssef Ben Said</h3>
                            <span>Paiements and Stores section</span>
                        </div>
                        <div class="team-social bg-light d-flex flex-column justify-content-center flex-shrink-0 p-4">
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-x-twitter"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->


    <!-- Testimonial Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-12 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.1s">
                    <div class="testimonial-title">
                        <h1 class="display-6 mb-4">What People Say About Our Activities.</h1>
                        <p class="fs-5 mb-0">We work to protect our planet, nurture life, and create a sustainable
                            future.</p>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8 col-xl-9">
                    <div class="owl-carousel testimonial-carousel wow fadeIn" data-wow-delay="0.3s">
                        <div class="testimonial-item">
                            <div class="row g-5 align-items-center">
                                <div class="col-md-6">
                                    <div class="testimonial-img">
                                        <img class="img-fluid" src="img/testimonial-1.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-text pb-5 pb-md-0">
                                        <div class="mb-2">
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                        </div>
                                        <p class="fs-5">Knowledge is the key to a better world. By supporting
                                            environmental programs,
                                            schools, and community training, we empower people to care for the Earth and
                                            build a sustainable future.</p>
                                        <div class="d-flex align-items-center">
                                            <div class="btn-lg-square bg-light text-secondary flex-shrink-0">
                                                <i class="fa fa-quote-right fa-2x"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h5 class="mb-0">Alexander Bell</h5>
                                                <span>CEO, Founder</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <div class="row g-5 align-items-center">
                                <div class="col-md-6">
                                    <div class="testimonial-img">
                                        <img class="img-fluid" src="img/testimonial-2.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-text pb-5 pb-md-0">
                                        <div class="mb-2">
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                        </div>
                                        <p class="fs-5">Every hand extended in kindness brings us closer to a world
                                            free
                                            from suffering. Be part of a global movement dedicated to building a future
                                            where equality and compassion thrive.</p>
                                        <div class="d-flex align-items-center">
                                            <div class="btn-lg-square bg-light text-secondary flex-shrink-0">
                                                <i class="fa fa-quote-right fa-2x"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h5 class="mb-0">Donald Pakura</h5>
                                                <span>CEO, Founder</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <div class="row g-5 align-items-center">
                                <div class="col-md-6">
                                    <div class="testimonial-img">
                                        <img class="img-fluid" src="img/testimonial-3.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-text pb-5 pb-md-0">
                                        <div class="mb-2">
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                            <i class="fa fa-star text-primary"></i>
                                        </div>
                                        <p class="fs-5">Through your generosity and volunteer spirit,
                                            we bring care to our planet and its people—protecting ecosystems,
                                            supporting communities, and inspiring lasting change.</p>
                                        <div class="d-flex align-items-center">
                                            <div class="btn-lg-square bg-light text-secondary flex-shrink-0">
                                                <i class="fa fa-quote-right fa-2x"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h5 class="mb-0">Boris Johnson</h5>
                                                <span>CEO, Founder</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


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
    @include('client.layouts.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#!" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
