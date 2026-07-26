<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentalMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DepartmentalMaterialController extends Controller
{
    /**
     * Public page listing all departments with Access Links ("Click Here").
     */
    public function index()
    {
        $departments = Department::active()
            ->withCount('materials')
            ->orderBy('name', 'asc')
            ->get();

        return view('pages.departmental_materials.index', compact('departments'));
    }

    /**
     * Public page displaying materials for a specific department.
     */
    public function showDepartment(Department $department)
    {
        $materials = $department->materials()->latest()->get();

        return view('pages.departmental_materials.show', compact('department', 'materials'));
    }

    /**
     * View/Read material online in browser.
     * - PDF & images → served inline (native browser viewer).
     * - DOC/DOCX/CSV/XLSX → downloaded directly (works offline/localhost).
     */
    public function viewOnline(DepartmentalMaterial $material)
    {
        $fullPath = Storage::disk('public')->path($material->file_path);

        if (!file_exists($fullPath)) {
            return back()->with('error', 'Requested file is no longer available on the server.');
        }

        $ext = strtolower($material->file_type);

        // Types browsers can render natively inline
        $inlineTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

        if (in_array($ext, $inlineTypes)) {
            $mime = Storage::disk('public')->mimeType($material->file_path) ?: 'application/octet-stream';
            return response()->file($fullPath, [
                'Content-Type'        => $mime,
                'Content-Disposition' => 'inline; filename="' . addslashes($material->title . '.' . $ext) . '"',
            ]);
        }

        // Non-renderable types (DOCX, CSV etc.) — download directly, works offline
        return Storage::disk('public')->download(
            $material->file_path,
            $material->title . '.' . $ext
        );
    }

    /**
     * Handle public material download (if allowed).
     */
    public function download(DepartmentalMaterial $material)
    {
        if (!$material->allow_download) {
            return back()->with('error', 'This material is configured as Read Only by the library administration and cannot be downloaded.');
        }

        $fullPath = Storage::disk('public')->path($material->file_path);

        if (!file_exists($fullPath)) {
            return back()->with('error', 'Requested file is no longer available on the server.');
        }

        $material->increment('downloads_count');

        return Storage::disk('public')->download($material->file_path, $material->title . '.' . $material->file_type);
    }

    /**
     * Admin view for managing departmental material uploads in Settings.
     */
    public function adminIndex(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $departments = Department::active()->orderBy('name', 'asc')->get();
        
        $selectedDepartmentId = $request->query('department_id');

        $materialsQuery = DepartmentalMaterial::with('department')->latest();
        if ($selectedDepartmentId) {
            $materialsQuery->where('department_id', $selectedDepartmentId);
        }
        $materials = $materialsQuery->paginate(15);

        return view('settings.departmental_materials.index', compact('departments', 'materials', 'selectedDepartmentId'));
    }

    /**
     * Admin store new departmental material file.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'department_id'  => 'required|exists:departments,id',
            'title'          => 'required|string|max:255',
            'course_code'    => 'nullable|string|max:50',
            'description'    => 'nullable|string',
            'allow_download' => 'nullable',
            'file'           => 'required|file|mimes:pdf,jpg,jpeg,png,gif,webp,doc,docx,csv,xlsx,xls|max:51200', // 50MB Max
        ], [
            'department_id.required' => 'Please select a target department.',
            'file.max' => 'The uploaded file size must not exceed 50MB.',
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $sizeBytes = $file->getSize();

        // Format file size cleanly
        if ($sizeBytes >= 1048576) {
            $fileSizeFormatted = number_format($sizeBytes / 1048576, 2) . ' MB';
        } elseif ($sizeBytes >= 1024) {
            $fileSizeFormatted = number_format($sizeBytes / 1024, 1) . ' KB';
        } else {
            $fileSizeFormatted = $sizeBytes . ' bytes';
        }

        $path = $file->store('departmental_materials', 'public');

        DepartmentalMaterial::create([
            'department_id'  => $validated['department_id'],
            'title'          => $validated['title'],
            'course_code'    => $validated['course_code'] ?? null,
            'description'    => $validated['description'] ?? null,
            'file_path'      => $path,
            'file_type'      => $extension ?: 'pdf',
            'file_size'      => $fileSizeFormatted,
            'allow_download' => $request->has('allow_download') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Departmental material uploaded successfully!');
    }

    /**
     * Admin edit form for departmental material.
     */
    public function edit(DepartmentalMaterial $material)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $departments = Department::active()->orderBy('name', 'asc')->get();

        return view('settings.departmental_materials.edit', compact('material', 'departments'));
    }

    /**
     * Admin update departmental material.
     */
    public function update(Request $request, DepartmentalMaterial $material)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'department_id'  => 'required|exists:departments,id',
            'title'          => 'required|string|max:255',
            'course_code'    => 'nullable|string|max:50',
            'description'    => 'nullable|string',
            'allow_download' => 'nullable',
            'file'           => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,webp,doc,docx,csv,xlsx,xls|max:51200',
        ]);

        $data = [
            'department_id'  => $validated['department_id'],
            'title'          => $validated['title'],
            'course_code'    => $validated['course_code'] ?? null,
            'description'    => $validated['description'] ?? null,
            'allow_download' => $request->has('allow_download') ? 1 : 0,
        ];

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if (Storage::disk('public')->exists($material->file_path)) {
                Storage::disk('public')->delete($material->file_path);
            }

            $file = $request->file('file');
            $extension = strtolower($file->getClientOriginalExtension());
            $sizeBytes = $file->getSize();

            if ($sizeBytes >= 1048576) {
                $fileSizeFormatted = number_format($sizeBytes / 1048576, 2) . ' MB';
            } elseif ($sizeBytes >= 1024) {
                $fileSizeFormatted = number_format($sizeBytes / 1024, 1) . ' KB';
            } else {
                $fileSizeFormatted = $sizeBytes . ' bytes';
            }

            $path = $file->store('departmental_materials', 'public');

            $data['file_path'] = $path;
            $data['file_type'] = $extension ?: 'pdf';
            $data['file_size'] = $fileSizeFormatted;
        }

        $material->update($data);

        return redirect()->route('settings.departmental-materials.index')->with('success', 'Material updated successfully!');
    }

    /**
     * Admin delete departmental material.
     */
    public function destroy(DepartmentalMaterial $material)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if (Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->back()->with('success', 'Material deleted successfully.');
    }
}
