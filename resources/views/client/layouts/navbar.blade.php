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
                @auth
                    <!-- Notifications -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle position-relative" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                  id="notificationCount" style="display: none;">
                0
            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{{ route('notifications.index') }}" class="dropdown-item">
                                View All Notifications
                            </a>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle position-relative" data-bs-toggle="dropdown">
                            <i class="fas fa-envelope"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                  id="messageCount" style="display: none;">
                0
            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{{ route('messagerie.index') }}" class="dropdown-item">
                                <i class="fas fa-inbox me-2"></i>Inbox
                            </a>
                            <a href="{{ route('messagerie.create') }}" class="dropdown-item">
                                <i class="fas fa-plus me-2"></i>New Message
                            </a>
                        </div>
                    </div>
                @endauth
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
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle text-dark position-relative" data-bs-toggle="dropdown">
                        <i class="fas fa-exclamation-circle"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end bg-light border border-primary shadow p-1">
                        <div class="d-flex align-items-center justify-content-between">
                            <button type="button" class="btn btn-sm btn-primary px-2 py-1 me-1 flex-fill" style="font-size: 0.75rem;" onclick="openComplaintWindow()">
                                Report an Issue
                            </button>
                            <a href="{{ route('complaints.user') }}" class="btn btn-sm btn-outline-primary px-2 py-1" style="font-size: 0.75rem;">
                                <i class="fas fa-list"></i>
                            </a>
                        </div>
                    </div>
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

<style>
    /* Notification et messages en blanc */
    .nav-bar .navbar .nav-link .fa-bell,
    .nav-bar .navbar .nav-link .fa-envelope {
        color: white !important;
    }

    /* Icônes dans les dropdown menus → noir */
    .nav-bar .navbar .dropdown-menu i {
        color: black !important;
    }

    /* Badge notification and messages */
    #notificationCount,
    #messageCount {
        background-color: red !important;
        color: white !important;
        font-size: 0.65rem;
        padding: 0.25rem 0.4rem;
        min-width: 18px;
        text-align: center;
    }

    /* Position badges closer to icons */
    .nav-item.dropdown .nav-link .badge {
        transform: translate(-50%, -50%) !important;
        top: 7px !important;
        left: 60% !important;
    }
</style>

@auth
    <script>
        // Function to update message count
        function updateMessageCount() {
            fetch('{{ route("messagerie.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('messageCount');
                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error fetching message count:', error));
        }

        // Update message count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateMessageCount();

            // Poll every 3 seconds for new messages
            setInterval(updateMessageCount, 100);
        });

        // Listen for real-time message events (if you're using Laravel Echo/Pusher)
        @if(config('broadcasting.default') !== 'null')
        window.Echo.private('App.Models.User.{{ Auth::id() }}')
            .listen('MessageSent', (e) => {
                updateMessageCount();
            });
        @endif
    </script>
@endauth
<script>
function openComplaintWindow() {
  const width = 600;
  const height = 700;
  const left = (screen.width / 2) - (width / 2);
  const top = (screen.height / 2) - (height / 2);

  window.open(
    "{{ route('complaints.create') }}", 
    "ComplaintWindow",
    `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=yes`
  );
}
</script>