<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'student' || !$user->student) {
            return response()->json(['success' => false], 403);
        }

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'action_type' => 'required|string|in:preview_abstract,read_digital',
        ]);

        ActivityLog::create([
            'student_id' => $user->student->id,
            'book_id' => $request->book_id,
            'action_type' => $request->action_type,
        ]);

        return response()->json(['success' => true]);
    }
}
