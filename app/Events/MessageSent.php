<?php

namespace App\Events;

use App\Models\Messagerie;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Messagerie $message)
    {
        $this->message = $message->load(['sender', 'receiver']);
    }

    public function broadcastOn(): array
    {
        // Diffusion aux deux utilisateurs
        return [
            new PrivateChannel('chat.' . $this->message->receiver_id),
            new PrivateChannel('chat.' . $this->message->sender_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'content' => $this->message->content,
            'sent_at' => $this->message->sent_at->toISOString(),
            'sender' => [
                'id' => $this->message->sender->id,
                'name' => $this->message->sender->first_name . ' ' . $this->message->sender->last_name,
            ],
            'receiver_id' => $this->message->receiver_id,
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    // Optionnel: Pour mieux gérer les erreurs
    public function broadcastWhen(): bool
    {
        return !is_null($this->message->sender) && !is_null($this->message->receiver);
    }
}
