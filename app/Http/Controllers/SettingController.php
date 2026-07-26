<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $settings = Setting::pluck('value', 'key')->toArray();

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'librarian_name' => 'required|string|max:255',
            'librarian_title' => 'required|string|max:255',
            'librarian_qualifications' => 'nullable|string',
            'librarian_bio' => 'nullable|string',
            'librarian_phone' => 'nullable|string|max:50',
            'librarian_image' => 'nullable|image|max:2048', // 2MB max
        ]);

        // Handle text settings
        $keys = ['librarian_name', 'librarian_title', 'librarian_qualifications', 'librarian_bio', 'librarian_phone'];
        
        foreach ($keys as $key) {
            if (isset($validated[$key])) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $validated[$key]]
                );
            }
        }

        // Handle image upload
        if ($request->hasFile('librarian_image')) {
            $path = $request->file('librarian_image')->store('images', 'public');
            
            Setting::updateOrCreate(
                ['key' => 'librarian_image_path'],
                ['value' => $path]
            );
        }

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
