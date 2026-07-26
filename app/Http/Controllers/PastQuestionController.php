<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\PastQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PastQuestionController extends Controller
{
    /**
     * Public page for viewing & downloading past questions.
     */
    public function publicIndex(Request $request)
    {
        $query = PastQuestion::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('course_code', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('year', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $pastQuestions = $query->paginate(12)->withQueryString();
        $departments = Department::active()->orderBy('name')->get();

        return view('pages.past_questions', compact('pastQuestions', 'departments'));
    }

    /**
     * Admin management index page.
     */
    public function adminIndex()
    {
        $pastQuestions = PastQuestion::latest()->get();
        $departments = Department::active()->orderBy('name')->get();
        return view('settings.past_questions.index', compact('pastQuestions', 'departments'));
    }

    /**
     * Upload & store new past question.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'department'     => 'nullable|string|max:255',
            'course_code'    => 'nullable|string|max:100',
            'year'           => 'nullable|string|max:50',
            'allow_download' => 'nullable',
            'file'           => 'required|file|mimes:pdf,jpg,jpeg,png,gif,webp,doc,docx,csv,xlsx,xls|max:51200',
        ]);

        $file = $request->file('file');
        $ext = strtolower($file->getClientOriginalExtension());
        $path = $file->store('past_questions', 'public');

        PastQuestion::create([
            'title'          => $request->title,
            'department'     => $request->department,
            'course_code'    => $request->course_code,
            'year'           => $request->year,
            'file_path'      => $path,
            'file_type'      => $ext,
            'allow_download' => $request->has('allow_download') ? 1 : 0,
        ]);

        return redirect()->route('settings.past-questions.index')->with('success', 'Past question uploaded successfully.');
    }

    /**
     * Admin edit form.
     */
    public function edit(PastQuestion $pastQuestion)
    {
        $departments = Department::active()->orderBy('name')->get();
        return view('settings.past_questions.edit', compact('pastQuestion', 'departments'));
    }

    /**
     * Admin update past question.
     */
    public function update(Request $request, PastQuestion $pastQuestion)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'department'     => 'nullable|string|max:255',
            'course_code'    => 'nullable|string|max:100',
            'year'           => 'nullable|string|max:50',
            'allow_download' => 'nullable',
            'file'           => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,webp,doc,docx,csv,xlsx,xls|max:51200',
        ]);

        $data = [
            'title'          => $request->title,
            'department'     => $request->department,
            'course_code'    => $request->course_code,
            'year'           => $request->year,
            'allow_download' => $request->has('allow_download') ? 1 : 0,
        ];

        if ($request->hasFile('file')) {
            // Delete the old file
            $oldPath = Storage::disk('public')->path($pastQuestion->file_path);
            if (file_exists($oldPath)) {
                Storage::disk('public')->delete($pastQuestion->file_path);
            }

            $file = $request->file('file');
            $ext  = strtolower($file->getClientOriginalExtension());
            $path = $file->store('past_questions', 'public');

            $data['file_path'] = $path;
            $data['file_type'] = $ext;
        }

        $pastQuestion->update($data);

        return redirect()->route('settings.past-questions.index')->with('success', 'Past question updated successfully.');
    }

    /**
     * Delete past question.
     */
    public function destroy(PastQuestion $pastQuestion)
    {
        $fullPath = Storage::disk('public')->path($pastQuestion->file_path);
        if ($pastQuestion->file_path && file_exists($fullPath)) {
            Storage::disk('public')->delete($pastQuestion->file_path);
        }

        $pastQuestion->delete();

        return redirect()->route('settings.past-questions.index')->with('success', 'Past question deleted successfully.');
    }

    /**
     * View/Read file online in browser.
     *
     * - PDF, images (jpg/jpeg/png/gif/webp/svg) → served INLINE (browser native viewer).
     * - All other types (doc, docx, csv, xlsx, xls) → served as DOWNLOAD
     *   because browsers cannot render them natively.
     *   This works fully offline on localhost without any external service.
     */
    public function viewOnline(PastQuestion $pastQuestion)
    {
        $fullPath = Storage::disk('public')->path($pastQuestion->file_path);

        if (!file_exists($fullPath)) {
            abort(404, 'File not found');
        }

        $ext = strtolower($pastQuestion->file_type);

        // Browser-renderable types — serve inline
        $inlineTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

        if (in_array($ext, $inlineTypes)) {
            $mime = Storage::disk('public')->mimeType($pastQuestion->file_path) ?: 'application/octet-stream';
            return response()->file($fullPath, [
                'Content-Type'        => $mime,
                'Content-Disposition' => 'inline; filename="' . addslashes($pastQuestion->title . '.' . $ext) . '"',
            ]);
        }

        // Non-renderable types (DOCX, CSV, XLSX etc.) — download directly
        // This works offline on localhost without any external service
        return Storage::disk('public')->download(
            $pastQuestion->file_path,
            $pastQuestion->title . '.' . $ext
        );
    }

    /**
     * Public download file route (only if allow_download is true).
     */
    public function download(PastQuestion $pastQuestion)
    {
        if (!$pastQuestion->allow_download) {
            return back()->with('error', 'This file is set to Read Only and cannot be downloaded.');
        }

        $fullPath = Storage::disk('public')->path($pastQuestion->file_path);

        if (!file_exists($fullPath)) {
            abort(404, 'File not found');
        }

        return Storage::disk('public')->download($pastQuestion->file_path, $pastQuestion->title . '.' . $pastQuestion->file_type);
    }
}
