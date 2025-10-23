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
                    <!-- Notifications Dropdown -->
                    <div class="nav-item dropdown notification-dropdown">
                        <a href="#" class="nav-link position-relative notification-bell"
                           data-bs-toggle="dropdown"
                           data-bs-auto-close="outside"
                           id="notificationDropdown">
                            <i class="fas fa-bell"></i>
                            <span class="badge rounded-pill bg-danger notification-badge" id="notificationCount">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end notification-menu" id="notificationMenu">
                            <!-- Header -->
                            <div class="notification-header">
                                <h6 class="mb-0">Notifications</h6>
                                <button class="btn btn-sm btn-link text-primary" id="markAllRead">
                                    Mark all as read
                                </button>
                            </div>

                            <!-- Notifications List -->
                            <div class="notification-list" id="notificationList">
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-bell-slash fs-2 mb-2"></i>
                                    <p class="mb-0">No notifications yet</p>
                                </div>
                            </div>

                            <!-- Footer - Removed View All link -->
                            <div class="notification-footer">
                                <!-- Empty footer or add something else if needed -->
                            </div>
                        </div>
                    </div>

                    <!-- Messages Dropdown -->
                    <div class="nav-item dropdown message-dropdown">
                        <a href="#" class="nav-link position-relative message-icon"
                           data-bs-toggle="dropdown"
                           data-bs-auto-close="outside"
                           id="messageDropdown">
                            <i class="fas fa-envelope"></i>
                            <span class="badge rounded-pill bg-danger message-badge" id="messageCount">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end message-menu" id="messageMenu">
                            <!-- Header -->
                            <div class="message-header">
                                <h6 class="mb-0">Messages</h6>
                                <a href="{{ route('messagerie.create') }}" class="btn btn-sm btn-link text-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>

                            <!-- Messages List -->
                            <div class="message-list" id="messageList">
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-envelope-open fs-2 mb-2"></i>
                                    <p class="mb-0">No messages yet</p>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="message-footer">
                                <a href="{{ route('messagerie.index') }}" class="btn btn-sm btn-outline-primary w-100">
                                    View All Messages
                                </a>
                            </div>
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
                                <a href="{{ route('profile.show') }}" class="dropdown-item">
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

<style>
    /* ========================================
       NOTIFICATION & MESSAGE ICONS
    ======================================== */
    .notification-bell i,
    .message-icon i {
        color: white !important;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .notification-bell:hover i,
    .message-icon:hover i {
        transform: scale(1.15);
    }

    /* Badge Styling */
    .notification-badge,
    .message-badge {
        position: absolute;
        top: -2px;
        right: -8px;
        background-color: #dc3545 !important;
        color: white !important;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.2em 0.5em;
        min-width: 20px;
        height: 20px;
        display: none;
        align-items: center;
        justify-content: center;
        border: 2px solid var(--bs-primary);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        animation: pulse 2s infinite;
    }

    .notification-badge.show,
    .message-badge.show {
        display: flex !important;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* ========================================
       DROPDOWN MENUS - FACEBOOK STYLE
    ======================================== */
    .notification-menu,
    .message-menu {
        width: 360px;
        max-height: 480px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        border-radius: 12px;
        padding: 0;
        margin-top: 10px;
        overflow: hidden;
    }

    /* Header */
    .notification-header,
    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        background: #fff;
        border-bottom: 1px solid #e4e6eb;
    }

    .notification-header h6,
    .message-header h6 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #050505;
        margin: 0;
    }

    .notification-header .btn-link,
    .message-header .btn-link {
        padding: 0;
        font-size: 0.875rem;
        text-decoration: none;
        font-weight: 600;
    }

    /* List Container */
    .notification-list,
    .message-list {
        max-height: 320px;
        overflow-y: auto;
        background: #fff;
    }

    /* Scrollbar Styling */
    .notification-list::-webkit-scrollbar,
    .message-list::-webkit-scrollbar {
        width: 8px;
    }

    .notification-list::-webkit-scrollbar-track,
    .message-list::-webkit-scrollbar-track {
        background: #f0f2f5;
    }

    .notification-list::-webkit-scrollbar-thumb,
    .message-list::-webkit-scrollbar-thumb {
        background: #bcc0c4;
        border-radius: 4px;
    }

    .notification-list::-webkit-scrollbar-thumb:hover,
    .message-list::-webkit-scrollbar-thumb:hover {
        background: #8a8d91;
    }

    /* ========================================
       NOTIFICATION ITEM
    ======================================== */
    .notification-item {
        display: flex;
        padding: 12px 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f2f5;
        text-decoration: none;
        color: inherit;
    }

    .notification-item:hover {
        background-color: #f2f3f5;
    }

    .notification-item.unread {
        background-color: #e7f3ff;
    }

    .notification-item.unread:hover {
        background-color: #d9edff;
    }

    .notification-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .notification-icon.info { background: #e7f3ff; color: #0084ff; }
    .notification-icon.success { background: #d4edda; color: #28a745; }
    .notification-icon.warning { background: #fff3cd; color: #ffc107; }
    .notification-icon.danger { background: #f8d7da; color: #dc3545; }

    .notification-content {
        flex: 1;
        min-width: 0;
    }

    .notification-title {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #050505;
        margin-bottom: 4px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .notification-time {
        font-size: 0.8125rem;
        color: #65676b;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .notification-dot {
        width: 12px;
        height: 12px;
        background: #0084ff;
        border-radius: 50%;
        margin-left: auto;
        flex-shrink: 0;
    }

    /* ========================================
       MESSAGE ITEM
    ======================================== */
    .message-item {
        display: flex;
        padding: 12px 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f2f5;
        text-decoration: none;
        color: inherit;
    }

    .message-item:hover {
        background-color: #f2f3f5;
    }

    .message-item.unread {
        background-color: #e7f3ff;
    }

    .message-item.unread:hover {
        background-color: #d9edff;
    }

    .message-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        margin-right: 12px;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .message-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .message-avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .message-status {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 14px;
        height: 14px;
        background: #31a24c;
        border: 3px solid white;
        border-radius: 50%;
    }

    .message-content {
        flex: 1;
        min-width: 0;
    }

    .message-sender {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #050505;
        margin-bottom: 4px;
    }

    .message-preview {
        font-size: 0.875rem;
        color: #65676b;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.3;
    }

    .message-item.unread .message-preview {
        font-weight: 600;
        color: #050505;
    }

    .message-time {
        font-size: 0.75rem;
        color: #65676b;
        margin-top: 4px;
    }

    .message-badge-dot {
        width: 12px;
        height: 12px;
        background: #0084ff;
        border-radius: 50%;
        margin-left: auto;
        flex-shrink: 0;
        align-self: center;
    }

    /* Footer */
    .notification-footer,
    .message-footer {
        padding: 12px 16px;
        background: #fff;
        border-top: 1px solid #e4e6eb;
    }

    .notification-footer .btn,
    .message-footer .btn {
        font-size: 0.9375rem;
        font-weight: 600;
    }

    /* Empty State */
    .notification-list .text-center,
    .message-list .text-center {
        padding: 40px 20px;
    }

    .notification-list .text-center i,
    .message-list .text-center i {
        color: #bcc0c4;
    }

    /* ========================================
       RESPONSIVE
    ======================================== */
    @media (max-width: 991.98px) {
        .notification-dropdown,
        .message-dropdown {
            width: 100%;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .notification-bell,
        .message-icon {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            width: 100%;
        }

        .notification-badge,
        .message-badge {
            position: static;
            margin-left: auto;
        }

        .notification-menu,
        .message-menu {
            width: 100%;
            max-width: 100%;
            margin-top: 0;
            border-radius: 0;
        }
    }

    @media (min-width: 992px) {
        .notification-dropdown,
        .message-dropdown {
            margin-right: 0.5rem;
        }

        .notification-bell,
        .message-icon {
            padding: 0.5rem 0.75rem;
        }
    }

    /* Loading State */
    .notification-loading,
    .message-loading {
        padding: 20px;
        text-align: center;
        color: #65676b;
    }

    .spinner-border-sm {
        width: 1.5rem;
        height: 1.5rem;
        border-width: 0.2em;
    }
</style>

@auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userId = {{ Auth::id() }};

            // ========================================
            // HELPER FUNCTIONS
            // ========================================
            function getCsrfToken() {
                // Try multiple ways to get CSRF token
                const metaTag = document.querySelector('meta[name="csrf-token"]');
                if (metaTag) {
                    return metaTag.content;
                }

                // Fallback: check for token in forms
                const tokenInput = document.querySelector('input[name="_token"]');
                if (tokenInput) {
                    return tokenInput.value;
                }

                // Final fallback: check Laravel global variable
                if (window.Laravel && window.Laravel.csrfToken) {
                    return window.Laravel.csrfToken;
                }

                console.warn('CSRF token not found');
                return '';
            }

            function escapeHtml(text) {
                if (!text) return '';
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function showToast(message, type = 'info') {
                // Create a simple toast notification
                const toast = document.createElement('div');
                toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
                toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

                document.body.appendChild(toast);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 3000);
            }

            function playNotificationSound() {
                try {
                    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();

                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);

                    oscillator.frequency.value = 800;
                    oscillator.type = 'sine';

                    gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);

                    oscillator.start(audioContext.currentTime);
                    oscillator.stop(audioContext.currentTime + 0.5);
                } catch (error) {
                    console.log('Audio context not supported');
                }
            }

            // ========================================
            // NOTIFICATIONS
            // ========================================
            function loadNotifications() {
                const notificationList = document.getElementById('notificationList');
                if (!notificationList) return;

                notificationList.innerHTML = '<div class="notification-loading"><div class="spinner-border spinner-border-sm text-primary"></div></div>';

                fetch('/notifications/recent')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        updateNotificationCount(data.unread_count);

                        if (data.notifications && data.notifications.length > 0) {
                            notificationList.innerHTML = data.notifications.map(notif => `
                        <a href="/notifications/${notif.id}" class="notification-item ${notif.is_unread ? 'unread' : ''}">
                            <div class="notification-icon ${notif.type || 'info'}">
                                <i class="fas ${getNotificationIcon(notif.type)}"></i>
                            </div>
                            <div class="notification-content">
                                <div class="notification-title">${escapeHtml(notif.title)}</div>
                                <div class="notification-time">
                                    <i class="far fa-clock"></i> ${notif.time_ago}
                                </div>
                            </div>
                            ${notif.is_unread ? '<div class="notification-dot"></div>' : ''}
                        </a>
                    `).join('');
                        } else {
                            notificationList.innerHTML = `
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-bell-slash fs-2 mb-2"></i>
                            <p class="mb-0">No notifications yet</p>
                        </div>
                    `;
                        }
                    })
                    .catch(error => {
                        console.error('Error loading notifications:', error);
                        notificationList.innerHTML = `
                    <div class="text-center py-4 text-danger">
                        <i class="fas fa-exclamation-triangle fs-2 mb-2"></i>
                        <p class="mb-0">Error loading notifications</p>
                    </div>
                `;
                    });
            }

            function updateNotificationCount(count) {
                const badge = document.getElementById('notificationCount');
                if (!badge) return;

                if (count > 0) {
                    badge.textContent = count > 99 ? '99+' : count;
                    badge.classList.add('show');
                } else {
                    badge.classList.remove('show');
                }
            }

            function getNotificationIcon(type) {
                const icons = {
                    'info': 'fa-info-circle',
                    'success': 'fa-check-circle',
                    'warning': 'fa-exclamation-triangle',
                    'danger': 'fa-times-circle',
                    'message': 'fa-envelope',
                    'event': 'fa-calendar',
                    'donation': 'fa-heart',
                    'comment': 'fa-comment',
                    'like': 'fa-heart',
                    'sponsor': 'fa-handshake',
                    'product': 'fa-box'
                };
                return icons[type] || 'fa-bell';
            }

            // Load notifications when dropdown is opened
            const notificationDropdown = document.getElementById('notificationDropdown');
            if (notificationDropdown) {
                notificationDropdown.addEventListener('click', function() {
                    loadNotifications();
                });
            }

            // Mark all as read
            const markAllReadBtn = document.getElementById('markAllRead');
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation(); // Prevent dropdown from closing

                    const csrfToken = getCsrfToken();

                    fetch('/notifications/mark-all-read', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Reload notifications to reflect changes
                                loadNotifications();

                                // Show success feedback
                                showToast('All notifications marked as read', 'success');
                            } else {
                                throw new Error(data.message || 'Failed to mark all as read');
                            }
                        })
                        .catch(error => {
                            console.error('Error marking all as read:', error);
                            showToast('Error marking notifications as read', 'error');
                        });
                });
            }

            // ========================================
            // MESSAGES
            // ========================================
            function loadMessages() {
                const messageList = document.getElementById('messageList');
                if (!messageList) return;

                messageList.innerHTML = '<div class="message-loading"><div class="spinner-border spinner-border-sm text-primary"></div></div>';

                fetch('/messagerie/recent')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        updateMessageCount(data.unread_count);

                        if (data.conversations && data.conversations.length > 0) {
                            messageList.innerHTML = data.conversations.map(conv => `
                        <a href="/messagerie/${conv.user_id}" class="message-item ${conv.has_unread ? 'unread' : ''}">
                            <div class="message-avatar">
                                ${conv.user_image
                                ? `<img src="${conv.user_image}" alt="${conv.user_name}">`
                                : `<div class="message-avatar-placeholder">${conv.user_initials}</div>`
                            }
                                <span class="message-status"></span>
                            </div>
                            <div class="message-content">
                                <div class="message-sender">${escapeHtml(conv.user_name)}</div>
                                <div class="message-preview">${escapeHtml(conv.last_message)}</div>
                                <div class="message-time">${conv.time_ago}</div>
                            </div>
                            ${conv.has_unread ? '<div class="message-badge-dot"></div>' : ''}
                        </a>
                    `).join('');
                        } else {
                            messageList.innerHTML = `
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-envelope-open fs-2 mb-2"></i>
                            <p class="mb-0">No messages yet</p>
                        </div>
                    `;
                        }
                    })
                    .catch(error => {
                        console.error('Error loading messages:', error);
                        messageList.innerHTML = `
                    <div class="text-center py-4 text-danger">
                        <i class="fas fa-exclamation-triangle fs-2 mb-2"></i>
                        <p class="mb-0">Error loading messages</p>
                    </div>
                `;
                    });
            }

            function updateMessageCount(count) {
                const badge = document.getElementById('messageCount');
                if (!badge) return;

                if (count > 0) {
                    badge.textContent = count > 99 ? '99+' : count;
                    badge.classList.add('show');
                } else {
                    badge.classList.remove('show');
                }
            }

            // Load messages when dropdown is opened
            const messageDropdown = document.getElementById('messageDropdown');
            if (messageDropdown) {
                messageDropdown.addEventListener('click', function() {
                    loadMessages();
                });
            }

            // ========================================
            // REAL-TIME UPDATES (Laravel Echo)
            // ========================================
            @if(config('broadcasting.default') !== 'null')
            if (window.Echo) {
                console.log('Echo initialized, listening to private channel:', `App.Models.User.${userId}`);

                // Listen to private user channel
                window.Echo.private(`App.Models.User.${userId}`)
                    .listen('.message.sent', (e) => {
                        console.log('✅ New message received:', e);
                        loadMessages();

                        if ('Notification' in window && Notification.permission === 'granted') {
                            new Notification('New Message', {
                                body: `${e.sender?.first_name || 'Someone'} ${e.sender?.last_name || ''}: ${e.content?.substring(0, 50) || 'New message'}${e.content?.length > 50 ? '...' : ''}`,
                                icon: '/favicon.ico'
                            });
                        }

                        playNotificationSound();
                    })
                    .listen('.notification.sent', (e) => {
                        console.log('✅ New notification received:', e);
                        loadNotifications();

                        if ('Notification' in window && Notification.permission === 'granted') {
                            new Notification(e.title || 'New Notification', {
                                body: e.message || 'You have a new notification',
                                icon: '/favicon.ico'
                            });
                        }

                        playNotificationSound();
                    })
                    .error((error) => {
                        console.error('❌ Echo connection error:', error);
                    });

                window.Echo.private(`chat.${userId}`)
                    .listen('.message.sent', (e) => {
                        console.log('✅ Chat message received:', e);
                        loadMessages();
                    });

                console.log('✅ Echo listeners registered successfully');
            } else {
                console.warn('⚠️ Echo is not available. Make sure bootstrap.js is loaded.');
            }
            @endif

            // ========================================
            // INITIAL LOAD & POLLING
            // ========================================

            // Initial load
            loadNotifications();
            loadMessages();

            // Poll every 60 seconds as backup
            setInterval(() => {
                fetch('/notifications/count')
                    .then(response => response.json())
                    .then(data => updateNotificationCount(data.count))
                    .catch(error => console.error('Error fetching notification count:', error));

                fetch('/messagerie/unread/count')
                    .then(response => response.json())
                    .then(data => updateMessageCount(data.count))
                    .catch(error => console.error('Error fetching message count:', error));
            }, 60000);

            // ========================================
            // BROWSER NOTIFICATIONS PERMISSION
            // ========================================

            if ('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission().then(permission => {
                    console.log('Notification permission:', permission);
                });
            }
        });
    </script>
@endauth
