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

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update(['status' => NotificationStatus::READ]);

        return back()->with('success', 'Notification marked as read');
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->where('status', '!=', NotificationStatus::READ)
            ->update(['status' => NotificationStatus::READ]);

        return back()->with('success', 'All notifications marked as read');
    }

    public function destroy(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->delete();
        return back()->with('success', 'Notification deleted');
    }

    public function getUnreadCount()
    {
        $count = Auth::user()->notifications()
            ->where('status', NotificationStatus::SENT)
            ->count();

        return response()->json(['count' => $count]);
    }
}
