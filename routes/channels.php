<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Messagerie;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Improved channel authorization for chats
Broadcast::channel('chat.{userId}', function ($user, $userId) {
    // Allow user to access their own chat channel
    // AND also allow access if they're participant in the conversation
    return (int) $user->id === (int) $userId ||
        Messagerie::where(function($query) use ($user, $userId) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $userId);
        })->orWhere(function($query) use ($user, $userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $user->id);
        })->exists();
});
