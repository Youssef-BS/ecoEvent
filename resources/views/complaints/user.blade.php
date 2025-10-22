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
    <link href="{{ asset('lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">

    <style>
        /* Complaints Page Styles */
        .complaint-card {
            position: relative;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .complaint-card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .complaint-card.has-reply {
            border-left: 4px solid #0000002e;
        }

        .reply-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(203, 223, 114, 0.15);
            color: rgba(32, 28, 28, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 10;
            border-radius: 10px;
        }

        .reply-content {
            text-align: center;
        }

        .reply-header {
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .reply-message {
            font-size: 1rem;
            line-height: 1.5;
        }

        .complaint-card .card-body {
            position: relative;
            z-index: 1;
        }

        .complaint-card.has-reply .card-body,
        .complaint-card.has-reply .card-footer {
            opacity: 0.3;
            pointer-events: none;
        }

        .img-thumbnail {
            max-width: 100%;
            height: auto;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.25rem;
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
        


    <!-- Page Header End -->

    <!-- Complaints Section Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-6 mb-4">My Complaints</h1>
                <p class="mb-0">Track and manage all your submitted complaints</p>
            </div>

            <!-- Complaints Cards -->
            <div class="row g-4" id="complaintsContainer">
                @foreach($complaints as $complaint)
                @php
                $createdDate = $complaint->created_at instanceof \Carbon\Carbon
                ? $complaint->created_at
                : \Carbon\Carbon::parse($complaint->created_at);
                $hasReply = !empty($complaint->reply);
                @endphp

                <div class="col-12">
                    <div class="card complaint-card h-100 {{ $hasReply ? 'has-reply' : '' }} wow fadeInUp" data-wow-delay="0.1s">
                        @if($hasReply)
                        <!-- Reply Overlay -->
                        <div class="reply-overlay">
                            <div class="reply-content">
                                <div class="reply-header">
                                    <i class="fa fa-check-circle me-2"></i>
                                    <strong>Admin Reply</strong>
                                </div>
                                <div class="reply-message">
                                    {{ $complaint->reply }}
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="badge bg-primary">{{ ucfirst($complaint->type) }}</span>
                                    <span class="badge {{ $complaint->status == 1 ? 'bg-success' : 'bg-warning' }} ms-2">
                                        {{ $complaint->status == 1 ? 'Resolved' : 'Pending' }}
                                    </span>
                                </div>
                                <small class="text-muted">{{ $createdDate->format('M d, Y') }}</small>
                            </div>

                            <p class="card-text">{{ $complaint->description }}</p>

                            @if($complaint->image)
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $complaint->image) }}" alt="Complaint Image"
                                    class="img-thumbnail" style="max-height: 150px;">
                            </div>
                            @endif
                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-end gap-2">
                                @if(!$hasReply)
                                <button class="btn btn-outline-primary btn-sm update-complaint-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#updateComplaintModal"
                                    data-id="{{ $complaint->idComplaint }}"
                                    data-description="{{ $complaint->description }}">
                                    <i class="fa fa-edit me-1"></i> Update
                                </button>
                                @else
                                <span></span> <!-- Empty space to maintain layout -->
                                @endif

                                <form action="{{ route('complaints.destroy', $complaint->idComplaint) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this complaint?')">
                                        <i class="fa fa-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @if($complaints->count() == 0)
                <div class="col-12 text-center py-5">
                    <i class="fa fa-inbox display-1 text-muted mb-3"></i>
                    <h4 class="text-muted">No Complaints Yet</h4>
                    <p class="text-muted">You haven't submitted any complaints yet.</p>
                    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addComplaintModal">
                        <i class="fa fa-plus me-2"></i>Submit Your First Complaint
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Complaints Section End -->

    <!-- Update Complaint Modal -->
    <div class="modal fade" id="updateComplaintModal" tabindex="-1" aria-labelledby="updateComplaintModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateComplaintModalLabel">Update Complaint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateComplaintForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="updateComplaintId" name="id">
                        <div class="mb-3">
                            <label for="updateComplaintDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="updateComplaintDescription" name="description" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Complaint</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-1.jpg')}}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-2.jpg')}}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-3.jpg')}}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-4.jpg')}}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-5.jpg')}}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-6.jpg')}}" alt="">
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
    <script src="{{ asset('lib/wow/wow.min.js')}}"></script>
    <script src="{{ asset('lib/easing/easing.min.js')}}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js')}}"></script>
    <script>
        // Handle update complaint button clicks
        document.querySelectorAll('.update-complaint-btn').forEach(button => {
            button.addEventListener('click', function() {
                const complaintId = this.getAttribute('data-id');
                const complaintDescription = this.getAttribute('data-description');

                document.getElementById('updateComplaintId').value = complaintId;
                document.getElementById('updateComplaintDescription').value = complaintDescription;

                // Update form action
                const form = document.getElementById('updateComplaintForm');
                form.action = `/complaints/${complaintId}`;
            });
        });

        // Handle delete complaint buttons
        document.querySelectorAll('.delete-complaint-btn').forEach(button => {
            button.addEventListener('click', function() {
                const complaintId = this.getAttribute('data-id');

                if (confirm('Are you sure you want to delete this complaint?')) {
                    // Create a form and submit it
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/complaints/${complaintId}`;

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    const tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = '_token';
                    tokenInput.value = csrfToken;

                    form.appendChild(methodInput);
                    form.appendChild(tokenInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });

        // Initialize animations
        new WOW().init();
    </script>
</body>

</html>