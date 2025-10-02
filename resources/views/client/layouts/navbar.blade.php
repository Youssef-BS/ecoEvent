

<div class="container-fluid bg-secondary px-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="nav-bar">
        <nav class="navbar navbar-expand-lg bg-primary navbar-dark px-4 py-lg-0">
            <h4 class="d-lg-none m-0">Menu</h4>
            <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav me-auto">
                    <a href="{{ route('home') }}" class="nav-item nav-link active">Home</a>
                    <a href="{{ route('about') }}" class="nav-item nav-link">About</a>
                    <a href="{{ route('service') }}" class="nav-item nav-link">Service</a>
                    <a href="{{ route('donation') }}" class="nav-item nav-link">Donation</a>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu bg-light m-0">
                            <a href="{{ route('event') }}" class="dropdown-item">Event</a>
                            <a href="{{ route('post.all') }}" class="dropdown-item">Post</a>
                            <a href="{{ route('feature') }}" class="dropdown-item">Feature</a>
                            <a href="{{ route('team') }}" class="dropdown-item">Our Team</a>
                            <a href="{{ route('testimonial') }}" class="dropdown-item">Testimonial</a>
                            <a href="#" class="dropdown-item">404 Page</a>
                        </div>
                    </div>

                    <a href="{{ route('contact') }}" class="nav-item nav-link">Contact</a>
                </div>

                <!-- Authentication Links -->
                <div class="navbar-nav ms-auto">
                    @auth
                        <!-- User is logged in - Show user menu and logout -->
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>
                                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                            </a>
                            <div class="dropdown-menu bg-light m-0">
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-user-circle me-2"></i>My Profile
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-heart me-2"></i>My Donations
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item border-0 bg-transparent">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- User is not logged in - Show login/register links -->
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>Account
                            </a>
                            <div class="dropdown-menu bg-light m-0">
                                <a href="{{ route('login') }}" class="dropdown-item">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </a>
                                <a href="{{ route('register') }}" class="dropdown-item">
                                    <i class="fas fa-user-plus me-2"></i>Register
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Social Media Links -->
                <div class="d-none d-lg-flex ms-3">
                    <a class="btn btn-square btn-dark ms-2" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-square btn-dark ms-2" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-dark ms-2" href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </nav>
    </div>
</div>
