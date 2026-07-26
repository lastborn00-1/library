<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Public index: view all staff.
     */
    public function index()
    {
        $staff = Staff::orderBy('order')->get();
        return view('pages.staff', compact('staff'));
    }

    /**
     * Admin index: list staff for management.
     */
    public function adminIndex()
    {
        $staff = Staff::orderBy('order')->get();
        return view('settings.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('settings.staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $validated;
        unset($data['image']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('staff', 'public');
        }

        Staff::create($data);

        return redirect()->route('settings.staff.index')->with('success', 'Staff member added successfully.');
    }

    public function edit(Staff $staff)
    {
        return view('settings.staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $validated;
        unset($data['image']);

        if ($request->hasFile('image')) {
            if ($staff->image_path) {
                Storage::disk('public')->delete($staff->image_path);
            }
            $data['image_path'] = $request->file('image')->store('staff', 'public');
        }

        $staff->update($data);

        return redirect()->route('settings.staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        if ($staff->image_path) {
            Storage::disk('public')->delete($staff->image_path);
        }
        $staff->delete();

        return redirect()->route('settings.staff.index')->with('success', 'Staff member deleted successfully.');
    }
}
