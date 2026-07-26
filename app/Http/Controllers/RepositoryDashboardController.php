<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class RepositoryDashboardController extends Controller
{
    public function index()
    {
        $totalProjects    = Project::count();
        $totalDepartments = Project::whereNotNull('department_name')
                                ->distinct('department_name')
                                ->count('department_name');
        $pendingProjects  = Project::where('status', 'pending')->count();

        $recentProjects = Project::with('authors')->latest()->take(5)->get();

        return view('repository.dashboard', compact(
            'totalProjects',
            'totalDepartments',
            'pendingProjects',
            'recentProjects'
        ));
    }
}
