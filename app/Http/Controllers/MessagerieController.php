<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Messagerie;
use App\Models\Notification;
use App\Enums\MessageStatus;
use App\Enums\NotificationType;
use App\Enums\NotificationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use Illuminate\Support\Str;

class MessagerieController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'Veuillez vous connecter.']);
        }

        $user = Auth::user();

        // Get all messages for this user, ordered by newest first
        $allMessages = Messagerie::where('receiver_id', $user->getAuthIdentifier())
            ->orWhere('sender_id', $user->getAuthIdentifier())
            ->with(['sender', 'receiver'])
            ->orderBy('sent_at', 'desc')
            ->get();

        // Group by conversation partner and get the latest message for each conversation
        $conversations = $allMessages->groupBy(function($message) use ($user) {
            return $message->sender_id === $user->getAuthIdentifier()
                ? $message->receiver_id
                : $message->sender_id;
        })->map(function($messages) {
            // Get the latest message for this conversation
            return $messages->sortByDesc('sent_at')->first();
        })->sortByDesc('sent_at'); // Sort conversations by latest message

        $unreadCount = Messagerie::where('receiver_id', $user->getAuthIdentifier())
            ->where('status', MessageStatus::SENT)
            ->count();

        return view('client.messagerie.index', compact('conversations', 'unreadCount'));
    }

    /**
     * Get recent conversations for dropdown (AJAX)
     */
    /**
     * Get recent conversations for dropdown (AJAX)
     */
    public function recent()
    {
        if (!Auth::check()) {
            return response()->json(['conversations' => [], 'unread_count' => 0]);
        }

        $user = Auth::user();

        // Get all messages for this user
        $allMessages = Messagerie::where('receiver_id', $user->id)
            ->orWhere('sender_id', $user->id)
            ->with(['sender', 'receiver'])
            ->orderBy('sent_at', 'desc')
            ->get();

        // Group by conversation partner and get the latest message for each conversation
        $conversations = $allMessages->groupBy(function($message) use ($user) {
            return $message->sender_id === $user->id
                ? $message->receiver_id
                : $message->sender_id;
        })->map(function($messages) use ($user) {
            // Get the latest message for this conversation
            $latestMessage = $messages->first(); // Already sorted by sent_at desc

            // Determine the other user (conversation partner)
            $otherUser = $latestMessage->sender_id === $user->id
                ? $latestMessage->receiver
                : $latestMessage->sender;

            // Check if there are unread messages from this user
            $hasUnread = $messages->where('receiver_id', $user->id)
                ->where('status', MessageStatus::SENT)
                ->isNotEmpty();

            // Get user initials for avatar placeholder
            $initials = strtoupper(substr($otherUser->first_name, 0, 1) . substr($otherUser->last_name, 0, 1));

            return [
                'user_id' => $otherUser->id,
                'user_name' => $otherUser->first_name . ' ' . $otherUser->last_name,
                'user_image' => $otherUser->profile_image ?? null,
                'user_initials' => $initials,
                'last_message' => Str::limit($latestMessage->content, 60),
                'time_ago' => $latestMessage->sent_at->diffForHumans(),
                'has_unread' => $hasUnread,
                'sent_at' => $latestMessage->sent_at->timestamp, // Add timestamp for proper sorting
            ];
        })
            ->sortByDesc('sent_at') // Sort by actual timestamp
            ->take(10) // Limit to 10 most recent conversations
            ->values(); // Reset array keys

        // Count total unread messages
        $unreadCount = Messagerie::where('receiver_id', $user->id)
            ->where('status', MessageStatus::SENT)
            ->count();

        return response()->json([
            'conversations' => $conversations,
            'unread_count' => $unreadCount,
        ]);
    }
    public function show($userId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'Veuillez vous connecter.']);
        }
        $user = Auth::user();
        $otherUser = User::findOrFail($userId);
        $messages = Messagerie::where(function($query) use ($user, $userId) {
            $query->where('sender_id', $user->getAuthIdentifier())
                ->where('receiver_id', $userId);
        })->orWhere(function($query) use ($user, $userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $user->getAuthIdentifier());
        })->orderBy('sent_at', 'asc')->get();

        // Marquer les messages comme lus
        Messagerie::where('receiver_id', $user->getAuthIdentifier())
            ->where('sender_id', $userId)
            ->where('status', '!=', MessageStatus::READ)
            ->update(['status' => MessageStatus::READ]);

        return view('client.messagerie.show', compact('messages', 'otherUser'));
    }

// Replace your store() method in MessagerieController with this:

    public function store(Request $request)
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Utilisateur non authentifié'
                ], 401);
            }
            return redirect()->route('login')->withErrors(['error' => 'Veuillez vous connecter.']);
        }

        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|min:1|max:1000',
        ]);

        // Vérification supplémentaire que le contenu n'est pas vide
        if (empty(trim($request->input('content')))) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Le message ne peut pas être vide'
                ], 422);
            }
            return back()->withErrors(['content' => 'Le message ne peut pas être vide']);
        }

        // Si le content est un JSON (par erreur), extraire le vrai content
        $content = trim($request->input('content'));
        if (json_decode($content, true) !== null) {
            $parsed = json_decode($content, true);
            if (isset($parsed['content'])) {
                $content = trim($parsed['content']);
            }
        }

        try {
            $user = Auth::user();
            $message = Messagerie::create([
                'sender_id' => $user->getAuthIdentifier(),
                'receiver_id' => $request->input('receiver_id'),
                'content' => $content,
                'sent_at' => now(),
                'status' => MessageStatus::SENT,
            ]);

            // Charger les relations pour l'événement
            $message->load(['sender', 'receiver']);

            // ✅ 1. Broadcast the MessageSent event
            broadcast(new MessageSent($message))->toOthers();

            // ✅ 2. Create notification
            $notification = Notification::create([
                'user_id' => $request->input('receiver_id'),
                'title' => 'Nouveau message',
                'message' => $user->first_name . ' ' . $user->last_name . ' vous a envoyé un message',
                'type' => 'message',
                'data' => json_encode([
                    'sender_id' => $user->id,
                    'message_preview' => Str::limit($content, 50),
                ]),
                'status' => NotificationStatus::SENT,
            ]);

            // ✅ 3. Broadcast the NotificationSent event
            broadcast(new \App\Events\NotificationSent($notification))->toOthers();

            // TOUJOURS retourner JSON pour les requêtes AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->route('messagerie.show', $request->input('receiver_id'))
                ->with('success', 'Message sent successfully');
        } catch (\Exception $e) {
            \Log::error('Error sending message: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Erreur lors de l\'envoi du message: ' . $e->getMessage()
                ], 500);
            }
            return back()->withErrors(['error' => 'Erreur lors de l\'envoi du message']);
        }
    }



    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'Veuillez vous connecter.']);
        }
        $users = User::where('id', '!=', Auth::id())->get();
        return view('client.messagerie.create', compact('users'));
    }

    public function destroy(Messagerie $messagerie)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'Veuillez vous connecter.']);
        }
        if ($messagerie->sender_id !== Auth::id()) {
            abort(403);
        }
        $messagerie->delete();
        return back()->with('success', 'Message deleted successfully');
    }

    /**
     * Get unread messages count for authenticated user
     */
    public function getUnreadCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Messagerie::where('receiver_id', Auth::id())
            ->where('status', MessageStatus::SENT)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function typing(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false], 401);
        }

        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'is_typing' => 'required|boolean',
        ]);

        $user = Auth::user();

        broadcast(new \App\Events\UserTyping(
            $user,
            $request->receiver_id,
            $request->is_typing
        ))->toOthers();

        return response()->json(['success' => true]);
    }
}
