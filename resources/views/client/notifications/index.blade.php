@extends('client.layouts.app')

@section('content')
<div class="container-fluid py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">
                        <i class="fas fa-bell me-2"></i>Notifications
                        @if($unreadCount > 0)
                        <span class="badge bg-danger">{{ $unreadCount }}</span>
                        @endif
                    </h2>
                    @if($notifications->total() > 0)
                    <form action="{{ route('notifications.markAllRead') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-check-double me-2"></i>Mark All as Read
                        </button>
                    </form>
                    @endif
                </div>

                <!-- Notifications List -->
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        @forelse($notifications as $notification)
                        <div class="notification-item border-bottom p-3 {{ $notification->status === App\Enums\NotificationStatus::SENT ? 'bg-light' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <!-- Notification Icon -->
                                        @switch($notification->notification_type)
                                        @case(App\Enums\NotificationType::ALERT)
                                        <div class="notification-icon bg-danger text-white me-3">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        @break
                                        @case(App\Enums\NotificationType::SYSTEM)
                                        <div class="notification-icon bg-info text-white me-3">
                                            <i class="fas fa-cog"></i>
                                        </div>
                                        @break
                                        @default
                                        <div class="notification-icon bg-primary text-white me-3">
                                            <i class="fas fa-info-circle"></i>
                                        </div>
                                        @endswitch

                                        <!-- Title and Time -->
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 {{ $notification->status === App\Enums\NotificationStatus::SENT ? 'fw-bold' : '' }}">
                                                {{ $notification->title }}
                                            </h6>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>

                                        <!-- Status Badge -->
                                        @if($notification->status === App\Enums\NotificationStatus::SENT)
                                        <span class="badge bg-primary ms-2">New</span>
                                        @endif
                                    </div>

                                    <!-- Notification Type Badge -->
                                    <span class="badge badge-sm
                                            @if($notification->notification_type === App\Enums\NotificationType::ALERT) bg-danger
                                            @elseif($notification->notification_type === App\Enums\NotificationType::SYSTEM) bg-info
                                            @else bg-secondary
                                            @endif">
                                        {{ $notification->notification_type->value }}
                                    </span>
                                </div>

                                <!-- Actions -->
                                <div class="d-flex gap-2 ms-3">
                                    @if($notification->status !== App\Enums\NotificationStatus::READ)
                                    <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Mark as read">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this notification?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Related Messages -->
                            @if($notification->messageries && $notification->messageries->count() > 0)
                            <div class="mt-3 ps-5">
                                <small class="text-muted">
                                    <i class="fas fa-paperclip me-1"></i>
                                    {{ $notification->messageries->count() }} related message(s)
                                </small>
                            </div>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No notifications</h5>
                            <p class="text-muted">You're all caught up!</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                @if($notifications->hasPages())
                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div class="toast show" role="alert">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

<style>
    .notification-item {
        transition: all 0.3s ease;
    }

    .notification-item:hover {
        background-color: #f8f9fa !important;
    }

    .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .badge-sm {
        font-size: 0.75rem;
        padding: 0.25em 0.6em;
    }
</style>
@endsection