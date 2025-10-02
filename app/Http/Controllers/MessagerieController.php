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
        $conversations = Messagerie::where('receiver_id', $user->getAuthIdentifier())
            ->orWhere('sender_id', $user->getAuthIdentifier())
            ->with(['sender', 'receiver'])
            ->orderBy('sent_at', 'desc')
            ->get()
            ->groupBy(function($message) use ($user) {
                return $message->sender_id === $user->getAuthIdentifier()
                    ? $message->receiver_id
                    : $message->sender_id;
            });
        $unreadCount = Messagerie::where('receiver_id', $user->getAuthIdentifier())
            ->where('status', MessageStatus::SENT)
            ->count();
        return view('client.messagerie.index', compact('conversations', 'unreadCount'));
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
            $message->load(['sender']);
            // Événement de diffusion
            broadcast(new MessageSent($message));
            // Notification avec extrait du message
            Notification::create([
                'user_id' => $request->input('receiver_id'),
                'title' => 'Nouveau message de ' . $user->first_name . ' ' . $user->last_name . ' : ' . Str::limit($content, 50),
                'notification_type' => NotificationType::INFO,
                'status' => NotificationStatus::SENT,
            ]);
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
}
