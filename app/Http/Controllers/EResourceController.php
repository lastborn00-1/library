<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\EResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EResourceController extends Controller
{
    /**
     * Admin: List e-resources
     */
    public function index()
    {
        $resources = EResource::orderBy('category')->orderBy('order')->get();
        $departments = Department::active()->orderBy('name')->get();
        return view('settings.eresources.index', compact('resources', 'departments'));
    }

    /**
     * Admin: Store new e-resource (supports URL link OR file upload)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'category'   => 'required|string|max:255',
            'school'     => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'order'      => 'nullable|integer',
            'url'        => 'nullable|url|max:2048',
            'file'       => 'nullable|file|mimes:pdf,doc,docx,txt,xls,xlsx,ppt,pptx|max:20480', // 20MB max
        ]);

        $data = [
            'title'      => $request->title,
            'category'   => $request->category,
            'school'     => $request->school,
            'department' => $request->department,
            'order'      => $request->order ?? 0,
        ];

        if ($request->hasFile('file')) {
            // File upload takes priority
            $path = $request->file('file')->store('eresources', 'public');
            $data['file_path'] = $path;
            $data['file_type'] = $request->file('file')->getClientOriginalExtension();
            $data['url']       = null;
        } elseif ($request->filled('url')) {
            $data['url']       = $request->url;
            $data['file_type'] = 'link';
        } else {
            return back()->withErrors(['url' => 'Please provide either a URL or upload a file.'])->withInput();
        }

        EResource::create($data);

        return redirect()->route('settings.eresources.index')->with('success', 'E-Resource added successfully.');
    }

    /**
     * Admin: Show edit form for e-resource
     */
    public function edit(EResource $eresource)
    {
        $departments = Department::active()->orderBy('name')->get();
        return view('settings.eresources.edit', compact('eresource', 'departments'));
    }

    /**
     * Admin: Update e-resource
     */
    public function update(Request $request, EResource $eresource)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'category'   => 'required|string|max:255',
            'school'     => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'url'        => 'nullable|url|max:2048',
            'file'       => 'nullable|file|mimes:pdf,doc,docx,txt,xls,xlsx,ppt,pptx|max:20480',
        ]);

        $data = [
            'title'      => $request->title,
            'category'   => $request->category,
            'school'     => $request->school,
            'department' => $request->department,
        ];

        if ($request->hasFile('file')) {
            if ($eresource->file_path) {
                Storage::disk('public')->delete($eresource->file_path);
            }
            $path = $request->file('file')->store('eresources', 'public');
            $data['file_path'] = $path;
            $data['file_type'] = $request->file('file')->getClientOriginalExtension();
            $data['url'] = null;
        } elseif ($request->filled('url')) {
            $data['url'] = $request->url;
            $data['file_type'] = 'link';
        }

        $eresource->update($data);

        return redirect()->route('settings.eresources.index')->with('success', 'E-Resource updated successfully.');
    }

    /**
     * Admin: Delete e-resource
     */
    public function destroy(EResource $eresource)
    {
        if ($eresource->file_path) {
            Storage::disk('public')->delete($eresource->file_path);
        }
        $eresource->delete();
        return redirect()->route('settings.eresources.index')->with('success', 'E-Resource removed.');
    }
}
