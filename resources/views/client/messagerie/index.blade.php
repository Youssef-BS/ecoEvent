@extends('layouts.app')
@section('content')
<div class="messenger-container">
    <div class="messenger-wrapper">
        <div class="row g-0 h-100">
            <!-- Sidebar with Conversations -->
            <div class="col-lg-5 col-xl-4 messenger-sidebar-full">
                <div class="sidebar-header">
                    <h3 class="mb-0">
                        <i class="fas fa-comment-dots me-2"></i>Chats
                    </h3>
                    <a href="{{ route('messagerie.create') }}" class="btn-compose" title="New message">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
                <!-- Search Bar -->
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search Messenger" id="searchInput">
                </div>
                <!-- Conversations List -->
                <div class="conversations-list-full" id="conversationsList">
                    @forelse($conversations as $userId => $messages)
                    @php
                    $lastMessage = $messages->first();
                    $otherUser = $lastMessage->sender_id === Auth::id()
                    ? $lastMessage->receiver
                    : $lastMessage->sender;
                    $unreadMessages = $messages->where('receiver_id', Auth::id())
                    ->where('status', App\Enums\MessageStatus::SENT)
                    ->count();
                    @endphp
                    <a href="{{ route('messagerie.show', $otherUser->id) }}"
                        class="conversation-item {{ $unreadMessages > 0 ? 'unread' : '' }}"
                        data-user-id="{{ $otherUser->id }}">
                        <div class="avatar-wrapper">
                            @if($otherUser->image)
                            <img src="{{ asset('storage/' . $otherUser->image) }}"
                                alt="{{ $otherUser->first_name }}">
                            @else
                            <div class="avatar-placeholder">
                                {{ substr($otherUser->first_name, 0, 1) }}{{ substr($otherUser->last_name, 0, 1) }}
                            </div>
                            @endif
                            <span class="status-indicator online"></span>
                        </div>
                        <div class="conversation-info">
                            <div class="conversation-header">
                                <h6>{{ $otherUser->first_name }} {{ $otherUser->last_name }}</h6>
                                <span class="message-time">{{ $lastMessage->sent_at->diffForHumans(null, true) }}</span>
                            </div>
                            <div class="conversation-preview">
                                <p class="last-message">
                                    @if($lastMessage->sender_id === Auth::id())
                                    <span class="you-label">You: </span>
                                    @endif
                                    {{ Str::limit($lastMessage->content, 40) }}
                                </p>
                                @if($unreadMessages > 0)
                                <span class="unread-badge">{{ $unreadMessages }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="empty-conversations">
                        <div class="empty-icon">
                            <i class="fas fa-comment-slash"></i>
                        </div>
                        <h5>No conversations yet</h5>
                        <p>Start chatting with your friends!</p>
                        <a href="{{ route('messagerie.create') }}" class="btn-start-chat">
                            <i class="fas fa-plus me-2"></i>Start New Chat
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
            <!-- Welcome Message / Select Conversation -->
            <div class="col-lg-7 col-xl-8 messenger-welcome">
                <div class="welcome-content">
                    <div class="welcome-icon">
                        <div class="icon-circle">
                            <i class="fas fa-comments"></i>
                        </div>
                    </div>
                    <h2>Your Messages</h2>
                    <p>Send private photos and messages to friends and groups</p>
                    <a href="{{ route('messagerie.create') }}" class="btn-send-message">
                        <i class="fas fa-paper-plane me-2"></i>Send Message
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@if(session('success'))
<div class="toast-notification show">
    <i class="fas fa-check-circle"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@push('scripts')
<script>
    // Refresh conversations on page load and visibility change
    function refreshConversations() {
        // Reload the page to get fresh data
        window.location.reload();
    }

    // Update when page becomes visible
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            refreshConversations();
        }
    });

    // Update when user returns to page
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            refreshConversations();
        }
    });

    // Update when window gains focus
    window.addEventListener('focus', function() {
        refreshConversations();
    });

    // Search functionality
    document.getElementById('searchInput')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const conversations = document.querySelectorAll('.conversation-item');
        conversations.forEach(conv => {
            const name = conv.querySelector('h6').textContent.toLowerCase();
            const message = conv.querySelector('.last-message').textContent.toLowerCase();
            if (name.includes(searchTerm) || message.includes(searchTerm)) {
                conv.style.display = 'flex';
            } else {
                conv.style.display = 'none';
            }
        });
    });

    // Auto-hide toast
    setTimeout(() => {
        document.querySelector('.toast-notification')?.classList.remove('show');
    }, 3000);

    // Listen for new messages (if using Laravel Echo)
    @if(config('broadcasting.default') !== 'null')
    window.Echo.private('chat.{{ Auth::id() }}')
        .listen('.message.sent', (e) => {
            console.log('New message received, refreshing conversations');
            refreshConversations();
        });
    @endif
</script>
@endpush

<style>
    /* Container */
    .messenger-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px;
    }

    .messenger-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        height: calc(100vh - 40px);
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    /* Sidebar Full */
    .messenger-sidebar-full {
        background: #fff;
        border-right: 1px solid #e4e6eb;
        display: flex;
        flex-direction: column;
    }

    .sidebar-header {
        padding: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e4e6eb;
    }

    .sidebar-header h3 {
        color: #050505;
        font-weight: 800;
        font-size: 28px;
    }

    .btn-compose {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-compose:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.5);
    }

    /* Search Bar */
    .search-bar {
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        background: #fff;
    }

    .search-bar i {
        color: #65676b;
        font-size: 16px;
    }

    .search-bar input {
        flex: 1;
        border: none;
        background: #f0f2f5;
        padding: 10px 16px;
        border-radius: 24px;
        font-size: 15px;
        outline: none;
    }

    .search-bar input:focus {
        background: #e4e6eb;
    }

    /* Conversations List */
    .conversations-list-full {
        flex: 1;
        overflow-y: auto;
    }

    .conversation-item {
        display: flex;
        align-items: center;
        padding: 12px 24px;
        text-decoration: none;
        color: #050505;
        transition: all 0.2s;
        position: relative;
    }

    .conversation-item:hover {
        background: #f0f2f5;
    }

    .conversation-item.unread {
        background: #f7f9fc;
    }

    .avatar-wrapper {
        position: relative;
        margin-right: 16px;
        flex-shrink: 0;
    }

    .avatar-wrapper img {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
    }

    .avatar-placeholder {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 22px;
    }

    .status-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 3px solid white;
        background: #31a24c;
    }

    .conversation-info {
        flex: 1;
        min-width: 0;
    }

    .conversation-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }

    .conversation-header h6 {
        margin: 0;
        font-weight: 600;
        font-size: 16px;
        color: #050505;
    }

    .message-time {
        font-size: 13px;
        color: #65676b;
    }

    .conversation-preview {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .last-message {
        margin: 0;
        font-size: 14px;
        color: #65676b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
    }

    .conversation-item.unread .last-message {
        font-weight: 600;
        color: #050505;
    }

    .you-label {
        color: #65676b;
        font-weight: 400;
    }

    .unread-badge {
        background: #0084ff;
        color: white;
        border-radius: 12px;
        padding: 2px 8px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 8px;
    }

    /* Empty State */
    .empty-conversations {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        text-align: center;
    }

    .empty-icon {
        font-size: 80px;
        color: #d0d3d7;
        margin-bottom: 24px;
    }

    .empty-conversations h5 {
        color: #050505;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .empty-conversations p {
        color: #65676b;
        margin-bottom: 24px;
    }

    .btn-start-chat {
        background: linear-gradient(135deg, #0084ff 0%, #00a2ff 100%);
        color: white;
        padding: 12px 24px;
        border-radius: 24px;
        text-decoration: none;
        font-weight: 600;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 12px rgba(0, 132, 255, 0.3);
    }

    .btn-start-chat:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 132, 255, 0.4);
        color: white;
    }

    /* Welcome Area */
    .messenger-welcome {
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .welcome-content {
        text-align: center;
        padding: 40px;
    }

    .welcome-icon {
        margin-bottom: 32px;
    }

    .icon-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .icon-circle i {
        font-size: 56px;
        color: white;
    }

    .welcome-content h2 {
        color: #050505;
        font-weight: 700;
        margin-bottom: 12px;
        font-size: 32px;
    }

    .welcome-content p {
        color: #65676b;
        font-size: 16px;
        margin-bottom: 32px;
    }

    .btn-send-message {
        background: linear-gradient(135deg, #0084ff 0%, #00a2ff 100%);
        color: white;
        padding: 14px 32px;
        border-radius: 28px;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 12px rgba(0, 132, 255, 0.3);
    }

    .btn-send-message:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 132, 255, 0.4);
        color: white;
    }

    /* Toast Notification */
    .toast-notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: linear-gradient(135deg, #00c853 0%, #00e676 100%);
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 6px 20px rgba(0, 200, 83, 0.4);
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .toast-notification.show {
        transform: translateY(0);
        opacity: 1;
    }

    .toast-notification i {
        font-size: 20px;
    }

    .toast-notification span {
        font-weight: 500;
    }

    /* Scrollbar */
    .conversations-list-full::-webkit-scrollbar {
        width: 6px;
    }

    .conversations-list-full::-webkit-scrollbar-track {
        background: transparent;
    }

    .conversations-list-full::-webkit-scrollbar-thumb {
        background: #ccd0d5;
        border-radius: 3px;
    }

    .conversations-list-full::-webkit-scrollbar-thumb:hover {
        background: #b0b3b8;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .messenger-welcome {
            display: none;
        }

        .messenger-sidebar-full {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .messenger-container {
            padding: 0;
        }

        .messenger-wrapper {
            border-radius: 0;
            height: 100vh;
        }

        .sidebar-header {
            padding: 16px 20px;
        }

        .sidebar-header h3 {
            font-size: 24px;
        }

        .search-bar {
            padding: 12px 20px;
        }

        .conversation-item {
            padding: 12px 20px;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .conversation-item {
        animation: fadeInUp 0.3s ease forwards;
    }

    .conversation-item:nth-child(1) {
        animation-delay: 0.05s;
    }

    .conversation-item:nth-child(2) {
        animation-delay: 0.1s;
    }

    .conversation-item:nth-child(3) {
        animation-delay: 0.15s;
    }

    .conversation-item:nth-child(4) {
        animation-delay: 0.2s;
    }

    .conversation-item:nth-child(5) {
        animation-delay: 0.25s;
    }
</style>
@endsection