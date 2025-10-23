@extends('layouts.app')
@section('content')
<div class="messenger-container">
    <div class="messenger-wrapper">
        <div class="row g-0 h-100">
            <!-- Sidebar - Conversations -->
            <div class="col-md-4 col-lg-3 messenger-sidebar">
                <div class="sidebar-header">
                    <h4 class="mb-0">
                        <i class="fas fa-comment-dots me-2"></i>Chats
                    </h4>
                    <a href="{{ route('messagerie.create') }}" class="btn-compose">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
                <div class="conversations-list">
                    <a href="{{ route('messagerie.show', $otherUser->id) }}" class="conversation-item active">
                        <div class="avatar-wrapper">
                            @if($otherUser->image)
                            <img src="{{ asset('storage/' . $otherUser->image) }}" alt="{{ $otherUser->first_name }}">
                            @else
                            <div class="avatar-placeholder">
                                {{ substr($otherUser->first_name, 0, 1) }}{{ substr($otherUser->last_name, 0, 1) }}
                            </div>
                            @endif
                            <span class="status-indicator online"></span>
                        </div>
                        <div class="conversation-info">
                            <h6>{{ $otherUser->first_name }} {{ $otherUser->last_name }}</h6>
                            <p class="last-message">Active now</p>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Chat Area -->
            <div class="col-md-8 col-lg-9 messenger-chat">

                <!-- Messages Area -->
                <div class="messages-area" id="chatMessages">
                    @forelse($messages as $message)
                    @if($message->sender_id === Auth::id())
                    <!-- Sent Message (Right - Blue Gradient) -->
                    <div class="message-wrapper sent">
                        <div class="message-bubble sent">
                            <p>{{ $message->content }}</p>
                            <span class="message-time">{{ $message->sent_at->format('H:i') }}</span>
                        </div>
                    </div>
                    @else
                    <!-- Received Message (Left - Gray) -->
                    <div class="message-wrapper received">
                        <div class="avatar-mini">
                            @if($otherUser->image)
                            <img src="{{ asset('storage/' . $otherUser->image) }}" alt="{{ $otherUser->first_name }}">
                            @else
                            <div class="avatar-placeholder-mini">
                                {{ substr($otherUser->first_name, 0, 1) }}
                            </div>
                            @endif
                        </div>
                        <div class="message-bubble received">
                            <p>{{ $message->content }}</p>
                            <span class="message-time">{{ $message->sent_at->format('H:i') }}</span>
                        </div>
                    </div>
                    @endif
                    @empty
                    <div class="empty-chat">
                        <div class="empty-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h5>Start the conversation!</h5>
                        <p>Say hi to {{ $otherUser->first_name }}</p>
                    </div>
                    @endforelse

                    <!-- Typing Indicator -->
                    <div id="typingIndicator" class="typing-indicator" style="display: none;">
                        <div class="message-wrapper received">
                            <div class="avatar-mini">
                                @if($otherUser->image)
                                <img src="{{ asset('storage/' . $otherUser->image) }}" alt="{{ $otherUser->first_name }}">
                                @else
                                <div class="avatar-placeholder-mini">
                                    {{ substr($otherUser->first_name, 0, 1) }}
                                </div>
                                @endif
                            </div>
                            <div class="message-bubble received typing-bubble">
                                <div class="typing-dots">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Input Area -->
                <div class="input-area">
                    <form id="messageForm" class="message-form">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                        <div class="input-wrapper">
                            <button type="button" class="btn-emoji">
                                <i class="far fa-smile"></i>
                            </button>
                            <textarea
                                id="messageContent"
                                name="content"
                                placeholder="Aa"
                                rows="1"
                                required></textarea>
                        </div>
                        <button type="submit" class="btn-send">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="module">
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {
            {
                Auth::id()
            }
        };
        const otherUserId = {
            {
                $otherUser - > id
            }
        };
        const chatMessages = document.getElementById('chatMessages');
        const messageForm = document.getElementById('messageForm');
        const contentTextarea = document.getElementById('messageContent');
        const typingIndicator = document.getElementById('typingIndicator');

        // Typing variables
        let typingTimer;
        let isTyping = false;

        // Auto-scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Auto-resize textarea
        contentTextarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 100) + 'px';
        });

        console.log('🚀 Connecting to WebSocket for user:', userId);
        console.log('🎯 Listening on channel: chat.' + userId);

        // Listen for new messages
        window.Echo.private('chat.' + userId)
            .listen('.message.sent', (e) => {
                console.log('📩 New message received:', e);

                if (e.sender.id === otherUserId) {
                    console.log('✅ Adding message to chat from:', e.sender.id);
                    addMessageToChat(e, false);
                } else {
                    console.log('❌ Ignoring message from sender:', e.sender.id);
                }
            })
            // Listen for typing events
            .listen('.user.typing', (e) => {
                console.log('⌨️ Typing event received:', e);

                if (e.user_id === otherUserId) {
                    if (e.is_typing) {
                        typingIndicator.style.display = 'block';
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    } else {
                        typingIndicator.style.display = 'none';
                    }
                }
            });

        // Send typing status
        function sendTypingStatus(typing) {
            fetch('{{ route("messagerie.typing") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    receiver_id: otherUserId,
                    is_typing: typing
                })
            }).catch(error => console.error('Error sending typing status:', error));
        }

        // Detect typing
        contentTextarea.addEventListener('input', function() {
            if (!isTyping) {
                isTyping = true;
                sendTypingStatus(true);
            }

            clearTimeout(typingTimer);

            typingTimer = setTimeout(function() {
                isTyping = false;
                sendTypingStatus(false);
            }, 2000);
        });

        // Stop typing on blur
        contentTextarea.addEventListener('blur', function() {
            if (isTyping) {
                clearTimeout(typingTimer);
                isTyping = false;
                sendTypingStatus(false);
            }
        });

        // Send message with AJAX
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const content = contentTextarea.value.trim();
            if (!content) return;

            // Stop typing indicator when sending
            if (isTyping) {
                clearTimeout(typingTimer);
                isTyping = false;
                sendTypingStatus(false);
            }

            const submitBtn = messageForm.querySelector('.btn-send');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            fetch('{{ route("messagerie.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        receiver_id: otherUserId,
                        content: content
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const messageData = {
                            content: content,
                            sent_at: new Date().toISOString(),
                            sender: {
                                id: userId
                            }
                        };
                        addMessageToChat(messageData, true);
                        contentTextarea.value = '';
                        contentTextarea.style.height = 'auto';
                    } else {
                        console.error('Error sending message:', data.error);
                        alert('Error sending message: ' + data.error);
                    }
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error sending message');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
                });
        });

        // Enter to send (Shift+Enter for new line)
        contentTextarea.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                messageForm.dispatchEvent(new Event('submit'));
            }
        });

        function addMessageToChat(messageData, isSent) {
            const time = new Date(messageData.sent_at).toLocaleTimeString('fr-FR', {
                hour: '2-digit',
                minute: '2-digit'
            });

            let messageHtml;
            if (isSent) {
                messageHtml = `
                        <div class="message-wrapper sent animate-in">
                            <div class="message-bubble sent">
                                <p>${escapeHtml(messageData.content)}</p>
                                <span class="message-time">${time}</span>
                            </div>
                        </div>
                    `;
            } else {
                messageHtml = `
                        <div class="message-wrapper received animate-in">
                            <div class="avatar-mini">
                                @if($otherUser->image)
                        <img src="{{ asset('storage/' . $otherUser->image) }}" alt="{{ $otherUser->first_name }}">
                                @else
                        <div class="avatar-placeholder-mini">
{{ substr($otherUser->first_name, 0, 1) }}
                        </div>
@endif
                        </div>
                        <div class="message-bubble received">
                            <p>${escapeHtml(messageData.content)}</p>
                                <span class="message-time">${time}</span>
                            </div>
                        </div>
                    `;
            }

            const emptyChat = chatMessages.querySelector('.empty-chat');
            if (emptyChat) {
                emptyChat.remove();
            }

            // Insert before typing indicator
            typingIndicator.insertAdjacentHTML('beforebegin', messageHtml);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            const newMessage = typingIndicator.previousElementSibling;
            newMessage.style.opacity = '0';
            newMessage.style.transform = 'translateY(20px)';

            setTimeout(() => {
                newMessage.style.transition = 'all 0.3s ease';
                newMessage.style.opacity = '1';
                newMessage.style.transform = 'translateY(0)';
            }, 50);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        setTimeout(() => {
            console.log('Echo connection state:', window.Echo.connector.socket.readyState);
            console.log('Subscribed channels:', window.Echo.connector.channels);
        }, 1000);
    });
</script>
@endpush
<style>
    /* Container */
    .messenger-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px;
        box-sizing: border-box;
    }

    .messenger-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        height: calc(100vh - 40px);
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        display: flex;
    }

    .messenger-wrapper .row {
        display: flex !important;
        flex-wrap: nowrap !important;
        height: 100% !important;
        width: 100% !important;
        margin: 0 !important;
        flex: 1 !important;
    }

    .messenger-wrapper .row>[class*="col-"] {
        padding: 0 !important;
        height: 100% !important;
        display: flex !important;
        flex-direction: column !important;
    }

    .messenger-sidebar {
        background: #fff;
        border-right: 1px solid #e4e6eb;
        display: flex !important;
        flex-direction: column !important;
        height: 100% !important;
    }

    .sidebar-header {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e4e6eb;
        flex-shrink: 0;
    }

    .sidebar-header h4 {
        color: #050505;
        font-weight: 700;
    }

    .btn-compose {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s;
    }

    .btn-compose:hover {
        transform: scale(1.1);
    }

    .conversations-list {
        overflow-y: auto;
        flex: 1;
        min-height: 0;
    }

    .conversation-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        text-decoration: none;
        color: #050505;
        transition: background 0.2s;
    }

    .conversation-item:hover {
        background: #f0f2f5;
    }

    .conversation-item.active {
        background: #f0f2f5;
    }

    .avatar-wrapper {
        position: relative;
        margin-right: 12px;
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
        font-size: 20px;
    }

    .status-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 2px solid white;
    }

    .status-indicator.online {
        background: #31a24c;
    }

    .conversation-info {
        flex: 1;
        min-width: 0;
    }

    .conversation-info h6 {
        margin: 0;
        font-weight: 600;
        font-size: 15px;
    }

    .conversation-info .last-message {
        margin: 0;
        font-size: 13px;
        color: #65676b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .messenger-chat {
        display: flex !important;
        flex-direction: column !important;
        background: #fff;
        height: 100% !important;
        position: relative !important;
        overflow: hidden !important;
        flex: 1 !important;
    }

    .messages-area {
        flex: 1 1 0 !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        padding: 20px;
        background: #fff;
        min-height: 0 !important;
    }

    .message-wrapper {
        display: flex;
        margin-bottom: 8px;
    }

    .message-wrapper.sent {
        justify-content: flex-end;
    }

    .message-wrapper.received {
        justify-content: flex-start;
    }

    .avatar-mini {
        width: 28px;
        height: 28px;
        margin-right: 8px;
        align-self: flex-end;
        flex-shrink: 0;
    }

    .avatar-mini img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .avatar-placeholder-mini {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12px;
    }

    .message-bubble {
        max-width: 60%;
        padding: 10px 16px;
        border-radius: 20px;
        position: relative;
        word-wrap: break-word;
    }

    .message-bubble.sent {
        background: linear-gradient(135deg, #0084ff 0%, #00a2ff 100%);
        color: white;
        border-bottom-right-radius: 4px;
        box-shadow: 0 2px 8px rgba(0, 132, 255, 0.3);
    }

    .message-bubble.received {
        background: #f0f2f5;
        color: #050505;
        border-bottom-left-radius: 4px;
    }

    .message-bubble p {
        margin: 0;
        font-size: 15px;
        line-height: 1.4;
    }

    .message-time {
        font-size: 11px;
        opacity: 0.7;
        margin-top: 4px;
        display: block;
    }

    /* Typing Indicator Styles */
    .typing-indicator {
        margin-bottom: 8px;
    }

    .typing-bubble {
        padding: 12px 16px !important;
        background: #f0f2f5 !important;
    }

    .typing-dots {
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .typing-dots span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #90949c;
        animation: typing 1.4s infinite;
    }

    .typing-dots span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-dots span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {

        0%,
        60%,
        100% {
            opacity: 0.3;
            transform: translateY(0);
        }

        30% {
            opacity: 1;
            transform: translateY(-8px);
        }
    }

    .animate-in {
        animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .empty-chat {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #65676b;
    }

    .empty-icon {
        font-size: 64px;
        color: #d0d3d7;
        margin-bottom: 16px;
    }

    .empty-chat h5 {
        margin-bottom: 8px;
    }

    .input-area {
        padding: 12px 24px !important;
        border-top: 1px solid #e4e6eb;
        background: #fff;
        flex-shrink: 0 !important;
        flex-grow: 0 !important;
        width: 100%;
        box-sizing: border-box;
    }

    .message-form {
        display: flex;
        gap: 8px;
        align-items: flex-end;
    }

    .input-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        background: #f0f2f5;
        border-radius: 24px;
        padding: 8px 16px;
    }

    .input-wrapper textarea {
        flex: 1;
        border: none;
        background: transparent;
        resize: none;
        outline: none;
        font-size: 15px;
        line-height: 20px;
        max-height: 100px;
        font-family: inherit;
    }

    .btn-emoji,
    .btn-attach {
        background: none;
        border: none;
        color: #0084ff;
        font-size: 20px;
        cursor: pointer;
        padding: 4px 8px;
        transition: transform 0.2s;
        flex-shrink: 0;
    }

    .btn-emoji:hover,
    .btn-attach:hover {
        transform: scale(1.2);
    }

    .btn-send {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0084ff 0%, #00a2ff 100%);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .btn-send:hover:not(:disabled) {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 132, 255, 0.4);
    }

    .btn-send:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .messages-area::-webkit-scrollbar,
    .conversations-list::-webkit-scrollbar {
        width: 6px;
    }

    .messages-area::-webkit-scrollbar-track,
    .conversations-list::-webkit-scrollbar-track {
        background: transparent;
    }

    .messages-area::-webkit-scrollbar-thumb,
    .conversations-list::-webkit-scrollbar-thumb {
        background: #ccd0d5;
        border-radius: 3px;
    }

    .messages-area::-webkit-scrollbar-thumb:hover,
    .conversations-list::-webkit-scrollbar-thumb:hover {
        background: #b0b3b8;
    }

    @media (max-width: 768px) {
        .messenger-container {
            padding: 0;
        }

        .messenger-wrapper {
            border-radius: 0;
            height: 100vh;
        }

        .messenger-sidebar {
            display: none !important;
        }
    }
</style>
@endsection