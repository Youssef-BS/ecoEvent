<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function showProfile()
    {
        /** @var User $user */
        $user = Auth::user();

        // Load relationships for the stats
        $user->load(['donations', 'posts', 'events']);

        return view('client.profile.profile', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Validate input
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'remove_image' => 'nullable|in:0,1',
        ]);

        try {
            // Handle image removal
            if ($request->has('remove_image') && $request->input('remove_image') == '1') {
                // Delete existing image from storage
                if ($user->image && Storage::disk('public')->exists($user->image)) {
                    Storage::disk('public')->delete($user->image);
                    Log::info('Deleted profile image: ' . $user->image);
                }
                $validated['image'] = null;
            }
            // Handle new image upload (only if remove_image is not set)
            elseif ($request->hasFile('image') && (!$request->has('remove_image') || $request->input('remove_image') == '0')) {
                // Delete old image if it exists
                if ($user->image && Storage::disk('public')->exists($user->image)) {
                    Storage::disk('public')->delete($user->image);
                    Log::info('Deleted old profile image: ' . $user->image);
                }

                // Store new image with unique name
                $file = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('profile_images', $imageName, 'public');

                $validated['image'] = $imagePath;

                Log::info('Uploaded new profile image: ' . $imagePath);
            } else {
                // Keep existing image - remove image field from validated data
                unset($validated['image']);
                unset($validated['remove_image']);
            }

            // Remove the remove_image flag from the data to be saved
            unset($validated['remove_image']);

            // Update user profile
            $user->update($validated);

            Log::info('Profile updated successfully for user ID: ' . $user->id);

            return redirect()
                ->route('profile.show')
                ->with('success', 'Profile updated successfully! 🎉');

        } catch (\Exception $e) {
            Log::error('Profile update error for user ' . $user->id . ': ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()
                ->with('error', 'Error updating profile: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Validate input
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed', // This requires new_password_confirmation field
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/', // Strong password
            ],
        ], [
            'new_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'new_password.confirmed' => 'Password confirmation does not match.',
        ]);

        try {
            // Verify current password
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()
                    ->withErrors(['current_password' => 'Current password is incorrect.'])
                    ->withInput();
            }

            // Check if new password is different from current
            if (Hash::check($validated['new_password'], $user->password)) {
                return back()
                    ->withErrors(['new_password' => 'New password must be different from current password.'])
                    ->withInput();
            }

            // Update password
            $user->update([
                'password' => Hash::make($validated['new_password'])
            ]);

            Log::info('Password updated successfully for user ID: ' . $user->id);

            return redirect()
                ->route('profile.show')
                ->with('success', 'Password updated successfully! 🔒');

        } catch (\Exception $e) {
            Log::error('Password update error for user ' . $user->id . ': ' . $e->getMessage());

            return back()
                ->with('error', 'Error updating password: ' . $e->getMessage());
        }
    }

    /**
     * Delete user account permanently
     */
    public function deleteAccount(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Validate confirmation
        $request->validate([
            'confirmation' => 'required|in:DELETE',
        ], [
            'confirmation.in' => 'You must type DELETE to confirm account deletion.',
        ]);

        try {
            $userId = $user->id;
            $userEmail = $user->email;

            // Delete profile image if exists
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
                Log::info('Deleted profile image during account deletion: ' . $user->image);
            }

            // You may want to delete related data here
            // For example:
            // $user->donations()->delete();
            // $user->posts()->delete();
            // $user->events()->delete();
            // $user->notifications()->delete();

            // OR use cascade delete in your database migration

            // Logout user
            Auth::logout();

            // Invalidate session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Delete the user
            $user->delete();

            Log::warning('Account deleted - User ID: ' . $userId . ', Email: ' . $userEmail);

            return redirect()
                ->route('home')
                ->with('success', 'Your account has been permanently deleted. We\'re sorry to see you go! 👋');

        } catch (\Exception $e) {
            Log::error('Account deletion error for user ' . $user->id . ': ' . $e->getMessage());

            return back()
                ->with('error', 'Error deleting account: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of all users (admin only - optional)
     */
    public function index()
    {
        // This would be for admin panel
        $users = User::latest()->paginate(20);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user (admin only - optional)
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user (admin only - optional)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user (admin only - optional)
     */
    public function show(User $user)
    {
        $user->load(['donations', 'posts', 'events']);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user (admin only - optional)
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user (admin only - optional)
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin',
        ]);

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user (admin only - optional)
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account from here.');
        }

        // Delete profile image
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
