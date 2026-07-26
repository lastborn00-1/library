<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectAuthor;
use Illuminate\Http\Request;

class RepositorySearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['authors'])
            ->where('status', 'approved')
            ->where('visibility', 'public');

        if ($request->filled('q')) {
            $searchTerm = $request->q;

            // Use MySQL full-text search for speed at scale (20k+ projects)
            // Falls back to LIKE for very short queries (< 3 chars)
            if (strlen($searchTerm) >= 3) {
                // Find project IDs via full-text search on projects table
                $projectIds = Project::whereFullText(
                    ['title', 'abstract', 'keywords'],
                    $searchTerm
                )->pluck('id');

                // Also search by author name / matric number
                $authorProjectIds = ProjectAuthor::where('student_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('matric_number', 'like', $searchTerm . '%')
                    ->pluck('project_id');

                $allIds = $projectIds->merge($authorProjectIds)->unique();

                $query->whereIn('id', $allIds);
            } else {
                // Short query: use fast indexed prefix search
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm . '%')
                      ->orWhere('keywords', 'like', $searchTerm . '%')
                      ->orWhereHas('authors', function ($aq) use ($searchTerm) {
                          $aq->where('matric_number', 'like', $searchTerm . '%');
                      });
                });
            }
        }

        $projects = $query->latest()->paginate(15);

        return view('repository.search', compact('projects'));
    }
}
