<?php
namespace App\Events;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
class UserTyping implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    public $receiverId;
    public $isTyping;
    public function __construct(User $user, int $receiverId, bool $isTyping = true)
    {
        $this->user = $user;
        $this->receiverId = $receiverId;
        $this->isTyping = $isTyping;
    }
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->receiverId),
        ];
    }
    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->first_name,
            'is_typing' => $this->isTyping,
        ];
    }
    public function broadcastAs(): string
    {
        return 'user.typing';
    }
}
