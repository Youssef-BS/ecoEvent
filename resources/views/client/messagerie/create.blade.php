@extends('layouts.app')
@section('content')
    <div class="messenger-container">
        <div class="messenger-wrapper">
            <div class="create-message-container">
                <!-- Header -->
                <div class="create-header">
                    <a href="{{ route('messagerie.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h4>New Message</h4>
                    <div></div>
                </div>
                <!-- Recipient Selection -->
                <div class="recipient-section">
                    <label>To:</label>
                    <div class="recipient-selector" id="recipientSelector">
                        <input type="text"
                               id="recipientSearch"
                               placeholder="Search people..."
                               autocomplete="off">
                    </div>
                </div>
                <!-- Users List -->
                <div class="users-list" id="usersList">
                    @foreach($users as $user)
                        <div class="user-item" data-user-id="{{ $user->id }}" data-user-name="{{ $user->first_name }} {{ $user->last_name }}">
                            <div class="avatar-wrapper">
                                @if($user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->first_name }}">
                                @else
                                    <div class="avatar-placeholder">
                                        {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="status-indicator online"></span>
                            </div>
                            <div class="user-info">
                                <h6>{{ $user->first_name }} {{ $user->last_name }}</h6>
                                <p>{{ $user->email }}</p>
                            </div>
                            <div class="user-action">
                                <button class="btn-select" type="button">
                                    <i class="far fa-circle"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Message Form (Hidden until user selected) -->
                <div class="message-form-container" id="messageFormContainer" style="display: none;">
                    <form action="{{ route('messagerie.store') }}" method="POST" id="newMessageForm">
                        @csrf
                        <input type="hidden" name="receiver_id" id="selectedUserId">
                        <div class="selected-user-info" id="selectedUserInfo">
                            <!-- Will be filled by JavaScript -->
                        </div>
                        <div id="successMessage" class="alert alert-success mt-3" style="display: none;"></div>
                        <div class="message-input-area">
                        <textarea
                            name="content"
                            id="messageContent"
                            placeholder="Write your message..."
                            rows="4"
                            maxlength="1000"
                            required
                            class="@error('content') is-invalid @enderror"
                        ></textarea>
                            <div class="char-counter">
                                <span id="charCount">0</span> / 1000
                            </div>
                            @error('content')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="message-actions">
                            <div class="action-buttons">
                                <button type="button" class="btn-action-icon" title="Emoji">
                                    <i class="far fa-smile"></i>
                                </button>
                                <button type="button" class="btn-action-icon" title="Attach file">
                                    <i class="fas fa-paperclip"></i>
                                </button>
                                <button type="button" class="btn-action-icon" title="Add image">
                                    <i class="far fa-image"></i>
                                </button>
                            </div>
                            <button type="submit" class="btn-send-message">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recipientSearch = document.getElementById('recipientSearch');
            const usersList = document.getElementById('usersList');
            const userItems = document.querySelectorAll('.user-item');
            const messageFormContainer = document.getElementById('messageFormContainer');
            const selectedUserId = document.getElementById('selectedUserId');
            const selectedUserInfo = document.getElementById('selectedUserInfo');
            const messageContent = document.getElementById('messageContent');
            const charCount = document.getElementById('charCount');
            const newMessageForm = document.getElementById('newMessageForm');
            const successMessage = document.getElementById('successMessage');
            let currentSelectedUser = null;
            // Search functionality
            recipientSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                userItems.forEach(item => {
                    const userName = item.dataset.userName.toLowerCase();
                    const userEmail = item.querySelector('.user-info p').textContent.toLowerCase();
                    if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
            // User selection
            userItems.forEach(item => {
                item.addEventListener('click', function() {
                    const userId = this.dataset.userId;
                    const userName = this.dataset.userName;
                    const userAvatar = this.querySelector('.avatar-wrapper').innerHTML;
                    // Deselect all
                    userItems.forEach(i => {
                        i.classList.remove('selected');
                        i.querySelector('.btn-select i').className = 'far fa-circle';
                    });
                    // Select current
                    this.classList.add('selected');
                    this.querySelector('.btn-select i').className = 'fas fa-check-circle';
                    // Update form
                    selectedUserId.value = userId;
                    currentSelectedUser = { id: userId, name: userName, avatar: userAvatar };
                    // Show selected user info
                    selectedUserInfo.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="avatar-wrapper me-3">
                        ${userAvatar}
                    </div>
                    <div>
                        <h6 class="mb-0">Sending to:</h6>
                        <p class="mb-0 text-primary fw-semibold">${userName}</p>
                    </div>
                </div>
            `;
                    // Hide success message if shown
                    successMessage.style.display = 'none';
                    // Show message form
                    messageFormContainer.style.display = 'block';
                    messageContent.focus();
                    // Scroll to form
                    messageFormContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                });
            });
            // Character counter
            messageContent.addEventListener('input', function() {
                charCount.textContent = this.value.length;
                if (this.value.length > 900) {
                    charCount.classList.add('text-danger');
                } else if (this.value.length > 800) {
                    charCount.classList.add('text-warning');
                    charCount.classList.remove('text-danger');
                } else {
                    charCount.classList.remove('text-warning', 'text-danger');
                }
            });
            // Auto-resize textarea
            messageContent.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 200) + 'px';
            });
            // AJAX form submission
            newMessageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const content = messageContent.value.trim();
                if (!content || !currentSelectedUser) return;
                const submitBtn = this.querySelector('.btn-send-message');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
                fetch('{{ route("messagerie.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        receiver_id: selectedUserId.value,
                        content: content
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Clear form
                            messageContent.value = '';
                            charCount.textContent = '0';
                            charCount.classList.remove('text-warning', 'text-danger');
                            messageContent.style.height = 'auto';
                            // Show success message
                            successMessage.innerHTML = `
                            <i class="fas fa-check-circle me-2"></i>
                            Message sent successfully to ${currentSelectedUser.name}!
                            <a href="/messagerie/${selectedUserId.value}" class="btn btn-primary btn-sm ms-3">View Conversation</a>
                        `;
                            successMessage.style.display = 'block';
                            // Auto-hide after 5 seconds
                            setTimeout(() => {
                                successMessage.style.transition = 'opacity 0.5s';
                                successMessage.style.opacity = '0';
                                setTimeout(() => {
                                    successMessage.style.display = 'none';
                                    successMessage.style.opacity = '1';
                                }, 500);
                            }, 5000);
                        } else {
                            alert(data.error || 'Error sending message');
                        }
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Send Message';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error sending message');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Send Message';
                    });
            });
        });
    </script>
    <style>
        .messenger-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        .messenger-wrapper {
            max-width: 800px;
            margin: 0 auto;
            height: calc(100vh - 40px);
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .create-message-container {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        /* Header */
        .create-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e4e6eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
        }
        .btn-back {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f0f2f5;
            color: #050505;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            text-decoration: none;
        }
        .btn-back:hover {
            background: #e4e6eb;
            color: #050505;
        }
        .create-header h4 {
            margin: 0;
            font-weight: 700;
            color: #050505;
        }
        /* Recipient Section */
        .recipient-section {
            padding: 16px 24px;
            border-bottom: 1px solid #e4e6eb;
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
        }
        .recipient-section label {
            color: #65676b;
            font-weight: 600;
            margin: 0;
        }
        .recipient-selector {
            flex: 1;
        }
        #recipientSearch {
            width: 100%;
            border: none;
            background: #f0f2f5;
            padding: 10px 16px;
            border-radius: 20px;
            font-size: 15px;
            outline: none;
        }
        #recipientSearch:focus {
            background: #e4e6eb;
        }
        /* Users List */
        .users-list {
            flex: 1;
            overflow-y: auto;
            background: #fff;
        }
        .user-item {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .user-item:hover {
            background: #f0f2f5;
        }
        .user-item.selected {
            background: #e7f3ff;
        }
        .user-item .avatar-wrapper {
            position: relative;
            margin-right: 16px;
            flex-shrink: 0;
        }
        .user-item .avatar-wrapper img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }
        .user-item .avatar-placeholder {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
        }
        .status-indicator {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid white;
            background: #31a24c;
        }
        .user-info {
            flex: 1;
            min-width: 0;
        }
        .user-info h6 {
            margin: 0 0 4px 0;
            font-weight: 600;
            font-size: 15px;
            color: #050505;
        }
        .user-info p {
            margin: 0;
            font-size: 13px;
            color: #65676b;
        }
        .user-action {
            margin-left: 12px;
        }
        .btn-select {
            width: 28px;
            height: 28px;
            border: none;
            background: none;
            color: #0084ff;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .user-item.selected .btn-select {
            color: #0084ff;
        }
        /* Message Form Container */
        .message-form-container {
            border-top: 2px solid #e4e6eb;
            padding: 20px 24px;
            background: #f7f9fc;
        }
        .selected-user-info {
            padding: 16px;
            background: #fff;
            border-radius: 12px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .selected-user-info .avatar-wrapper img,
        .selected-user-info .avatar-placeholder {
            width: 40px;
            height: 40px;
        }
        .selected-user-info .avatar-placeholder {
            font-size: 16px;
        }
        .selected-user-info h6 {
            font-size: 13px;
            color: #65676b;
            margin-bottom: 4px;
        }
        .selected-user-info p {
            font-size: 16px;
        }
        #successMessage {
            border-radius: 8px;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        #successMessage a {
            text-decoration: none;
        }
        .message-input-area {
            margin-bottom: 16px;
        }
        .message-input-area textarea {
            width: 100%;
            border: 2px solid #e4e6eb;
            background: #fff;
            padding: 16px;
            border-radius: 12px;
            font-size: 15px;
            line-height: 1.5;
            resize: none;
            outline: none;
            transition: border-color 0.2s;
            font-family: inherit;
        }
        .message-input-area textarea:focus {
            border-color: #0084ff;
        }
        .message-input-area textarea.is-invalid {
            border-color: #dc3545;
        }
        .char-counter {
            margin-top: 8px;
            text-align: right;
            font-size: 13px;
            color: #65676b;
        }
        .char-counter .text-warning {
            color: #ffc107;
        }
        .char-counter .text-danger {
            color: #dc3545;
        }
        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: 8px;
        }
        .message-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        .btn-action-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: #f0f2f5;
            color: #0084ff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 18px;
        }
        .btn-action-icon:hover {
            background: #e4e6eb;
            transform: scale(1.1);
        }
        .btn-send-message {
            background: linear-gradient(135deg, #0084ff 0%, #00a2ff 100%);
            color: white;
            padding: 12px 28px;
            border-radius: 24px;
            border: none;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(0, 132, 255, 0.3);
        }
        .btn-send-message:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 132, 255, 0.4);
        }
        .btn-send-message:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        /* Scrollbar */
        .users-list::-webkit-scrollbar {
            width: 6px;
        }
        .users-list::-webkit-scrollbar-track {
            background: transparent;
        }
        .users-list::-webkit-scrollbar-thumb {
            background: #ccd0d5;
            border-radius: 3px;
        }
        .users-list::-webkit-scrollbar-thumb:hover {
            background: #b0b3b8;
        }
        /* Responsive */
        @media (max-width: 768px) {
            .messenger-container {
                padding: 0;
            }
            .messenger-wrapper {
                border-radius: 0;
                height: 100vh;
            }
        }
    </style>
@endsection
