<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function listUsers()
    {
        $users = User::all();
        return view('admin.users.listUsers', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users',
            'phone'      => 'nullable|string|max:20',
            'password'   => 'required|min:6',
            'role'       => 'nullable|string',
            'image'      => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('users', 'public');
        }
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('users.listUsers')->with('success', 'User created successfully!');
    }

    public function showProfile($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.showProfile', compact('user'));
    }

    public function edit(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone'      => 'nullable|string|max:20',
            'role'       => 'nullable|string',
            'image'      => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $request->file('image')->store('users', 'public');
        }

        $user->update($data);

        return redirect()->route('users.showProfile', $user->id)->with('success', 'Profile updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();

        return redirect()->route('users.listUsers')->with('success', 'User deleted successfully!');
    }
}
