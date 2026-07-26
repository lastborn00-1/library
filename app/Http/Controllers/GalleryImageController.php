<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    /**
     * Admin: List gallery images
     */
    public function index()
    {
        $images = GalleryImage::orderBy('order')->latest()->get();
        return view('settings.gallery.index', compact('images'));
    }

    /**
     * Admin: Store new gallery image
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // 5MB max
            'caption' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        GalleryImage::create([
            'image_path' => $path,
            'caption' => $request->caption,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('settings.gallery.index')->with('success', 'Image added to gallery.');
    }

    /**
     * Admin: Update gallery image details
     */
    public function update(Request $request, GalleryImage $gallery)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255',
        ]);

        $gallery->update([
            'caption' => $request->caption,
        ]);

        return redirect()->route('settings.gallery.index')->with('success', 'Image details updated.');
    }

    /**
     * Admin: Delete gallery image
     */
    public function destroy(GalleryImage $gallery)
    {
        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }
        $gallery->delete();

        return redirect()->route('settings.gallery.index')->with('success', 'Image removed from gallery.');
    }
}
