<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepositoryStatisticsController extends Controller
{
    public function index()
    {
        $projectsByDepartment = Project::select('department_name', DB::raw('count(*) as projects_count'))
            ->whereNotNull('department_name')
            ->groupBy('department_name')
            ->get()
            ->map(function($item) {
                return (object) [
                    'name' => $item->department_name,
                    'projects_count' => $item->projects_count
                ];
            });

        // Calculate storage used
        $storageBytes = 0;
        $files = \Illuminate\Support\Facades\Storage::disk('local')->allFiles('repository/pdfs');
        foreach ($files as $file) {
            $storageBytes += \Illuminate\Support\Facades\Storage::disk('local')->size($file);
        }
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $storageFormatted = '0 B';
        if ($storageBytes > 0) {
            $pow = floor(($storageBytes ? log($storageBytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);
            $storageBytes /= (1 << (10 * $pow));
            $storageFormatted = round($storageBytes, 2) . ' ' . $units[$pow];
        }

        $stats = [
            'total_projects' => Project::count(),
            'approved_projects' => Project::where('status', 'approved')->count(),
            'pending_projects' => Project::where('status', 'pending')->count(),
            'by_department' => $projectsByDepartment,
            'storage_used' => $storageFormatted
        ];

        return view('repository.statistics', compact('stats'));
    }
}
