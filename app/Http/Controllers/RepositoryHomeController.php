<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class RepositoryHomeController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type'); // 'staff' or 'student'

        // Fetch recent public items (approved and public visibility)
        $query = Project::with('authors')
            ->where('status', 'approved')
            ->where('visibility', 'public');

        if ($type === 'staff') {
            $query->where('author_type', 'staff');
        } elseif ($type === 'student') {
            $query->where('author_type', 'student');
        }

        $recentItems = $query->latest('created_at')->take(10)->get();

        // Fetch counts by type
        $typeCountsQuery = Project::where('status', 'approved')
            ->where('visibility', 'public');

        if ($type === 'staff') {
            $typeCountsQuery->where('author_type', 'staff');
        } elseif ($type === 'student') {
            $typeCountsQuery->where('author_type', 'student');
        }

        $typeCounts = $typeCountsQuery->selectRaw('project_type, count(*) as count')
            ->groupBy('project_type')
            ->pluck('count', 'project_type');

        return view('repository.home', compact('recentItems', 'typeCounts', 'type'));
    }
}
