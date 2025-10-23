<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Enums\NotificationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $unreadCount = Auth::user()->notifications()
            ->where('status', NotificationStatus::SENT)
            ->count();

        return view('client.notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Get recent notifications for dropdown (AJAX)
     */
    public function recent()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title ?? $notification->message,
                    'message' => $notification->message,
                    'type' => $notification->type ?? 'info', // info, success, warning, danger
                    'is_unread' => $notification->status === NotificationStatus::SENT,
                    'time_ago' => $notification->created_at->diffForHumans(),
                    'url' => route('notifications.show', $notification->id),
                ];
            });

        $unreadCount = Auth::user()->notifications()
            ->where('status', NotificationStatus::SENT)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Get unread notification count (AJAX)
     */
    public function count()
    {
        $count = Auth::user()->notifications()
            ->where('status', NotificationStatus::SENT)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Show single notification and mark as read, then redirect to target
     */
    public function show(Notification $notification)
    {
        // Check authorization
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        // Mark as read if unread
        if ($notification->status === NotificationStatus::SENT) {
            $notification->update(['status' => NotificationStatus::READ]);
        }

        // Get redirect URL based on notification type and data
        $redirectUrl = $this->getRedirectUrl($notification);

        return redirect($redirectUrl);
    }

    /**
     * Mark a single notification as read (AJAX)
     */
    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update(['status' => NotificationStatus::READ]);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
            ]);
        }

        return back()->with('success', 'Notification marked as read');
    }


    /**
     * Mark all notifications as read (AJAX + Web)
     */
    public function markAllAsRead(Request $request)
    {
        // Mark all SENT notifications as READ
        $updatedCount = Auth::user()->notifications()
            ->where('status', NotificationStatus::SENT)
            ->update(['status' => NotificationStatus::READ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'All notifications have been marked as read',
                'count' => $updatedCount,
            ]);
        }

        return back()->with('success', 'All notifications have been marked as read');
    }

    /**
     * Delete a notification
     */
    public function destroy(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notification deleted',
            ]);
        }

        return back()->with('success', 'Notification deleted');
    }

    /**
     * Get redirect URL based on notification type and data
     */
    /**
     * Get redirect URL based on notification type and data
     */
    private function getRedirectUrl(Notification $notification): string
    {
        // If notification has a direct URL stored, use it
        if (!empty($notification->url)) {
            return $notification->url;
        }

        // Parse notification data if it's JSON
        $data = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;

        // Determine redirect based on notification type
        if (!empty($notification->type)) {
            switch ($notification->type) {
                case 'message':
                case 'new_message':
                    // Redirect to conversation with the sender
                    if (!empty($data['sender_id'])) {
                        return route('messagerie.show', $data['sender_id']);
                    }
                    return route('messagerie.index');

                case 'comment':
                case 'new_comment':
                    // Redirect to post with the comment
                    if (!empty($data['post_id'])) {
                        return route('post.view', $data['post_id']) . '#comment-' . ($data['comment_id'] ?? '');
                    }
                    return route('post.all');

                case 'like':
                case 'post_liked':
                    // Redirect to the liked post
                    if (!empty($data['post_id'])) {
                        return route('post.view', $data['post_id']);
                    }
                    return route('post.all');

                case 'event':
                case 'event_reminder':
                case 'event_updated':
                    // Redirect to event details
                    if (!empty($data['event_id'])) {
                        return route('events.show', $data['event_id']);
                    }
                    return route('event');

                case 'donation':
                case 'donation_received':
                    // Redirect to donations page
                    return route('donation');

                case 'sponsor':
                case 'new_sponsor':
                    // Redirect to sponsors
                    if (!empty($data['sponsor_id'])) {
                        return route('sponsors.show', $data['sponsor_id']);
                    }
                    return route('sponsors.index');

                case 'product':
                case 'new_product':
                    // Redirect to product
                    if (!empty($data['event_id']) && !empty($data['product_id'])) {
                        return route('products.show', [
                            'event' => $data['event_id'],
                            'product' => $data['product_id']
                        ]);
                    }
                    return route('event');

                case 'profile':
                case 'account':
                    // Redirect to profile
                    return route('profile.show');

                default:
                    // Default: redirect to home instead of notifications index
                    return route('home');
            }
        }

        // Fallback: redirect to home
        return route('home');
    }
}
