<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Librarian;
use Illuminate\Support\Facades\Hash;

class LibrarianController extends Controller
{
    public function index()
    {
        $librarians = Librarian::with('user')->latest()->get();
        return view('librarians.index', compact('librarians'));
    }

    public function create()
    {
        return view('librarians.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:255',
            'qualifications' => 'nullable|string',
            'bio' => 'nullable|string',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'librarian',
        ]);

        $librarianData = [
            'user_id' => $user->id,
            'phone' => $validated['phone'] ?? null,
            'status' => 'active',
        ];

        $imagePath = null;
        if ($request->hasFile('profile_photo')) {
            $imagePath = $request->file('profile_photo')->store('librarians', 'public');
            $librarianData['profile_photo'] = $imagePath;
        }

        Librarian::create($librarianData);

        return redirect()->route('librarians.index')->with('success', 'Librarian added successfully.');
    }

    public function edit(Librarian $librarian)
    {
        return view('librarians.edit', compact('librarian'));
    }

    public function update(Request $request, Librarian $librarian)
    {
        $validated = $request->validate([
            'phone'       => 'nullable|string|max:20',
            'status'      => 'required|in:active,inactive',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $data = ['phone' => $validated['phone'], 'status' => $validated['status']];

        if ($request->hasFile('profile_photo')) {
            if ($librarian->profile_photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($librarian->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('librarians', 'public');
        }

        $librarian->update($data);

        return redirect()->route('librarians.index')->with('success', 'Librarian updated successfully.');
    }

    public function destroy(Librarian $librarian)
    {
        $librarian->user()->update(['role' => 'student']);
        $librarian->delete();
        return redirect()->route('librarians.index')->with('success', 'Librarian removed.');
    }
}
