<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RepositoryProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('authors')->latest()->paginate(15);
        return view('repository.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('repository.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'abstract'        => 'nullable|string',
            'keywords'        => 'nullable|string|max:500',
            'department_name' => 'nullable|string|max:255',
            'academic_session'=> 'nullable|string|max:255',
            'supervisor_name' => 'nullable|string|max:255',
            'project_type'    => 'nullable|string|max:255',
            'author_type'     => 'required|in:student,staff',
            'status'          => 'required|in:pending,approved,rejected',
            'visibility'      => 'required|in:public,internal,private',
            'pdf_file'        => 'required|file|extensions:pdf|max:102400',
            'authors'                      => 'required|array|min:1',
            'authors.*.student_name'       => 'required|string|max:255',
            'authors.*.matric_number'      => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Handle PDF upload
            $pdfPath = $request->file('pdf_file')->store('repository/pdfs', 'local');

            $project = Project::create([
                'title'           => $validated['title'],
                'abstract'        => $validated['abstract'] ?? null,
                'keywords'        => $validated['keywords'] ?? null,
                'department_name' => $validated['department_name'] ?? null,
                'academic_session'=> $validated['academic_session'] ?? null,
                'supervisor_name' => $validated['supervisor_name'] ?? null,
                'project_type'    => $validated['project_type'] ?? null,
                'author_type'     => $validated['author_type'],
                'status'          => $validated['status'],
                'visibility'      => $validated['visibility'],
                'pdf_path'        => $pdfPath,
                'created_by'      => auth()->id(),
            ]);

            foreach ($validated['authors'] as $index => $authorData) {
                $project->authors()->create([
                    'student_name'  => $authorData['student_name'],
                    'matric_number' => $authorData['matric_number'],
                    'email'         => $authorData['email'] ?? null,
                    'phone'         => $authorData['phone'] ?? null,
                    'author_order'  => $index + 1,
                ]);
            }

            DB::commit();
            return redirect()->route('repository.projects.index')
                             ->with('success', 'Project uploaded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                         ->withErrors(['error' => 'Failed to save project: ' . $e->getMessage()]);
        }
    }

    public function show(Project $project)
    {
        $project->load(['authors', 'files']);
        return view('repository.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $project->load('authors');
        return view('repository.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'abstract'        => 'nullable|string',
            'keywords'        => 'nullable|string|max:500',
            'department_name' => 'nullable|string|max:255',
            'academic_session'=> 'nullable|string|max:255',
            'supervisor_name' => 'nullable|string|max:255',
            'project_type'    => 'nullable|string|max:255',
            'author_type'     => 'required|in:student,staff',
            'status'          => 'required|in:pending,approved,rejected',
            'visibility'      => 'required|in:public,internal,private',
            'pdf_file'        => 'nullable|file|extensions:pdf|max:102400',
            'authors'                  => 'required|array|min:1',
            'authors.*.student_name'   => 'required|string|max:255',
            'authors.*.matric_number'  => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $updateData = [
                'title'           => $validated['title'],
                'abstract'        => $validated['abstract'] ?? null,
                'keywords'        => $validated['keywords'] ?? null,
                'department_name' => $validated['department_name'] ?? null,
                'academic_session'=> $validated['academic_session'] ?? null,
                'supervisor_name' => $validated['supervisor_name'] ?? null,
                'project_type'    => $validated['project_type'] ?? null,
                'author_type'     => $validated['author_type'],
                'status'          => $validated['status'],
                'visibility'      => $validated['visibility'],
                'updated_by'      => auth()->id(),
            ];

            if ($request->hasFile('pdf_file')) {
                // Delete old PDF
                if ($project->pdf_path && Storage::disk('local')->exists($project->pdf_path)) {
                    Storage::disk('local')->delete($project->pdf_path);
                }
                $updateData['pdf_path'] = $request->file('pdf_file')->store('repository/pdfs', 'local');
            }

            $project->update($updateData);

            // Recreate authors
            $project->authors()->delete();
            foreach ($validated['authors'] as $index => $authorData) {
                $project->authors()->create([
                    'student_name'  => $authorData['student_name'],
                    'matric_number' => $authorData['matric_number'],
                    'email'         => $authorData['email'] ?? null,
                    'phone'         => $authorData['phone'] ?? null,
                    'author_order'  => $index + 1,
                ]);
            }

            DB::commit();
            return redirect()->route('repository.projects.show', $project)
                             ->with('success', 'Project updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                         ->withErrors(['error' => 'Failed to update project: ' . $e->getMessage()]);
        }
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('repository.projects.index')
                         ->with('success', 'Project deleted successfully.');
    }

    public function downloadPdf(Project $project)
    {
        if ($project->pdf_path && Storage::disk('local')->exists($project->pdf_path)) {
            return Storage::disk('local')->download($project->pdf_path, $project->title . '.pdf');
        }
        abort(404, 'PDF file not found.');
    }

    /**
     * Show public metadata for a project.
     * Accessible to everyone for public items.
     */
    public function showPublic(Project $project)
    {
        // Only allow viewing if public, OR if the user is authenticated.
        if ($project->visibility !== 'public' && !auth()->check()) {
            return redirect()->route('login')->with('error', 'You must log in to view this item.');
        }
        
        // If it's not approved, only admins/librarians should see it
        if ($project->status !== 'approved' && (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'librarian']))) {
            abort(404, 'Item not available.');
        }

        $project->load('authors');
        return view('repository.show_public', compact('project'));
    }

    /**
     * Serve PDF inline for reading — no download prompt.
     * Accessible to all for public items, authenticated users for private/internal.
     * Librarians can download via downloadPdf() instead.
     */
    public function viewPdf(Project $project)
    {
        // Enforce visibility
        if ($project->visibility !== 'public' && !auth()->check()) {
            return redirect()->route('login')->with('error', 'You must log in to read this document.');
        }

        if (!$project->pdf_path || !Storage::disk('local')->exists($project->pdf_path)) {
            abort(404, 'PDF file not found.');
        }

        $fileContent = Storage::disk('local')->get($project->pdf_path);

        return response($fileContent, 200)
            ->header('Content-Type', 'application/pdf')
            // 'inline' tells the browser to display it, not download it
            ->header('Content-Disposition', 'inline; filename="' . str_replace('"', '', $project->title) . '.pdf"')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->header('X-Content-Type-Options', 'nosniff');
    }
}
