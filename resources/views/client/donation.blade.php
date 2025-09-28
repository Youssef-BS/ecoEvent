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

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600;700&family=Open+Sans&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
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

    <!-- Page Header End -->




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


    <!-- Donation Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">Donation</p>
                <h1 class="display-6 mb-4">Our Donation Causes Around the World</h1>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="donation-item d-flex h-100 p-4">
                        <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                            <h6 class="mb-0">Raised</h6>
                            <span class="mb-2">$8000</span>
                            <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                <div class="progress-bar w-100 bg-secondary" role="progressbar" aria-valuenow="85"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <span class="fs-4">85%</span>
                                </div>
                            </div>
                            <h6 class="mb-0">Goal</h6>
                            <span>$10000</span>
                        </div>
                        <div class="donation-detail">
                            <div class="position-relative mb-4">
                                <img class="img-fluid w-100" src="img/donation-1.jpg" alt="">
                                <a href="#!"
                                    class="btn btn-sm btn-secondary px-3 position-absolute top-0 end-0">Food</a>
                            </div>
                            <a href="#!" class="h3 d-inline-block">Healthy Food</a>
                            <p>Through your donations and volunteer work, we spread kindness and support to children.
                            </p>
                            <a href="#!" class="btn btn-primary w-100 py-3"><i class="fa fa-plus me-2"></i>Donate
                                Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.13s">
                    <div class="donation-item d-flex h-100 p-4">
                        <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                            <h6 class="mb-0">Raised</h6>
                            <span class="mb-2">$8000</span>
                            <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                <div class="progress-bar w-100 bg-secondary" role="progressbar" aria-valuenow="95"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <span class="fs-4">95%</span>
                                </div>
                            </div>
                            <h6 class="mb-0">Goal</h6>
                            <span>$10000</span>
                        </div>
                        <div class="donation-detail">
                            <div class="position-relative mb-4">
                                <img class="img-fluid w-100" src="img/donation-2.jpg" alt="">
                                <a href="#!"
                                    class="btn btn-sm btn-secondary px-3 position-absolute top-0 end-0">Health</a>
                            </div>
                            <a href="#!" class="h3 d-inline-block">Water Treatment</a>
                            <p>Through your donations and volunteer work, we spread kindness and support to children.
                            </p>
                            <a href="#!" class="btn btn-primary w-100 py-3"><i class="fa fa-plus me-2"></i>Donate
                                Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="donation-item d-flex h-100 p-4">
                        <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                            <h6 class="mb-0">Raised</h6>
                            <span class="mb-2">$8000</span>
                            <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                <div class="progress-bar w-100 bg-secondary" role="progressbar" aria-valuenow="75"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <span class="fs-4">75%</span>
                                </div>
                            </div>
                            <h6 class="mb-0">Goal</h6>
                            <span>$10000</span>
                        </div>
                        <div class="donation-detail">
                            <div class="position-relative mb-4">
                                <img class="img-fluid w-100" src="img/donation-3.jpg" alt="">
                                <a href="#!"
                                    class="btn btn-sm btn-secondary px-3 position-absolute top-0 end-0">Education</a>
                            </div>
                            <a href="#!" class="h3 d-inline-block">Education Support</a>
                            <p>Through your donations and volunteer work, we spread kindness and support to children.
                            </p>
                            <a href="#!" class="btn btn-primary w-100 py-3"><i class="fa fa-plus me-2"></i>Donate
                                Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="donation-item d-flex h-100 p-4">
                        <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                            <h6 class="mb-0">Raised</h6>
                            <span class="mb-2">$8000</span>
                            <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                <div class="progress-bar w-100 bg-secondary" role="progressbar" aria-valuenow="85"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <span class="fs-4">85%</span>
                                </div>
                            </div>
                            <h6 class="mb-0">Goal</h6>
                            <span>$10000</span>
                        </div>
                        <div class="donation-detail">
                            <div class="position-relative mb-4">
                                <img class="img-fluid w-100" src="img/donation-1.jpg" alt="">
                                <a href="#!"
                                    class="btn btn-sm btn-secondary px-3 position-absolute top-0 end-0">Food</a>
                            </div>
                            <a href="#!" class="h3 d-inline-block">Healthy Food</a>
                            <p>Through your donations and volunteer work, we spread kindness and support to children.
                            </p>
                            <a href="#!" class="btn btn-primary w-100 py-3"><i class="fa fa-plus me-2"></i>Donate
                                Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.13s">
                    <div class="donation-item d-flex h-100 p-4">
                        <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                            <h6 class="mb-0">Raised</h6>
                            <span class="mb-2">$8000</span>
                            <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                <div class="progress-bar w-100 bg-secondary" role="progressbar" aria-valuenow="95"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <span class="fs-4">95%</span>
                                </div>
                            </div>
                            <h6 class="mb-0">Goal</h6>
                            <span>$10000</span>
                        </div>
                        <div class="donation-detail">
                            <div class="position-relative mb-4">
                                <img class="img-fluid w-100" src="img/donation-2.jpg" alt="">
                                <a href="#!"
                                    class="btn btn-sm btn-secondary px-3 position-absolute top-0 end-0">Health</a>
                            </div>
                            <a href="#!" class="h3 d-inline-block">Water Treatment</a>
                            <p>Through your donations and volunteer work, we spread kindness and support to children.
                            </p>
                            <a href="#!" class="btn btn-primary w-100 py-3"><i class="fa fa-plus me-2"></i>Donate
                                Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="donation-item d-flex h-100 p-4">
                        <div class="donation-progress d-flex flex-column flex-shrink-0 text-center me-4">
                            <h6 class="mb-0">Raised</h6>
                            <span class="mb-2">$8000</span>
                            <div class="progress d-flex align-items-end w-100 h-100 mb-2">
                                <div class="progress-bar w-100 bg-secondary" role="progressbar" aria-valuenow="75"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <span class="fs-4">75%</span>
                                </div>
                            </div>
                            <h6 class="mb-0">Goal</h6>
                            <span>$10000</span>
                        </div>
                        <div class="donation-detail">
                            <div class="position-relative mb-4">
                                <img class="img-fluid w-100" src="img/donation-3.jpg" alt="">
                                <a href="#!"
                                    class="btn btn-sm btn-secondary px-3 position-absolute top-0 end-0">Education</a>
                            </div>
                            <a href="#!" class="h3 d-inline-block">Education Support</a>
                            <p>Through your donations and volunteer work, we spread kindness and support to children.
                            </p>
                            <a href="#!" class="btn btn-primary w-100 py-3"><i class="fa fa-plus me-2"></i>Donate
                                Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Donation End -->


    <!-- Donate Start -->
    <div class="container-fluid donate py-5">
        <div class="container">
            <div class="row g-0">
                <div class="col-lg-7 donate-text bg-light py-5 wow fadeIn" data-wow-delay="0.1s">
                    <div class="d-flex flex-column justify-content-center h-100 p-5 wow fadeIn" data-wow-delay="0.3s">
                        <h1 class="display-6 mb-4">Let's Donate to Needy People for Better Lives</h1>
                        <p class="fs-5 mb-0">Through your donations, we spread kindness and support to children,
                            families, and communities struggling to find stability.</p>
                    </div>
                </div>
                <div class="col-lg-5 donate-form bg-primary py-5 text-center wow fadeIn" data-wow-delay="0.5s">
                    <div class="h-100 p-5">
                        <form>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" placeholder="Your Name">
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Your Email">
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1"
                                            autocomplete="off" checked>
                                        <label class="btn btn-light" for="btnradio1">$10</label>

                                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2"
                                            autocomplete="off">
                                        <label class="btn btn-light" for="btnradio2">$20</label>

                                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3"
                                            autocomplete="off">
                                        <label class="btn btn-light" for="btnradio3">$30</label>

                                        <input type="radio" class="btn-check" name="btnradio" id="btnradio4"
                                            autocomplete="off">
                                        <label class="btn btn-light" for="btnradio4">$40</label>

                                        <input type="radio" class="btn-check" name="btnradio" id="btnradio5"
                                            autocomplete="off">
                                        <label class="btn btn-light" for="btnradio5">$50</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-secondary py-3 w-100" type="submit">Donate Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Donate End -->


    <!-- Newsletter Start -->
    <div class="container-fluid bg-primary py-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-6 mb-4">Subscribe the Newsletter</h1>
                    <div class="position-relative w-100 mb-2">
                        <input class="form-control border-0 w-100 ps-4 pe-5" type="text" placeholder="Enter Your Email"
                            style="height: 60px;">
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
                        <a class="btn btn-square btn-primary me-2" href="#!"><i class="fab fa-x-twitter"></i></a>
                        <a class="btn btn-square btn-primary me-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-primary me-2" href="#!"><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-primary me-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
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
                            <img class="img-fluid w-100" src="img/gallery-1.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="img/gallery-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="img/gallery-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="img/gallery-4.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="img/gallery-5.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="img/gallery-6.jpg" alt="">
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
                        Designed By <a class="fw-semi-bold" href="https://htmlcodex.com">HTML Codex</a>. Distributed by
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
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
