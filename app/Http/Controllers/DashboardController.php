<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\Student;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'student') {
            return $this->studentDashboard($user);
        }

        return $this->adminDashboard();
    }

    private function adminDashboard()
    {
        $totalDepartments = \App\Models\Department::count();
        $totalBooks = Book::count();
        $totalCopies = Book::sum('quantity');
        $borrowedBooks = Transaction::where('status', 'borrowed')->count();
        $overdueBooks = Transaction::where('status', 'borrowed')
            ->where('due_date', '<', now())
            ->count();
        $totalStudents = Student::count();
        $pendingRequests = Transaction::whereIn('status', ['requested', 'pending_return'])->count();

        $recentActivity = Transaction::with(['student', 'book'])
            ->latest('updated_at')
            ->take(6)
            ->get();

        return view('dashboard', compact('totalDepartments', 'totalBooks', 'totalCopies', 'borrowedBooks', 'overdueBooks', 'totalStudents', 'pendingRequests', 'recentActivity'));
    }

    private function studentDashboard($user)
    {
        $student = $user->student;
        
        if (!$student) {
            abort(404, 'Student record not found.');
        }

        $currentlyBorrowed = Transaction::where('student_id', $student->id)
            ->where('status', 'borrowed')
            ->with('book')
            ->get();

        $pendingRequests = Transaction::where('student_id', $student->id)
            ->where('status', 'requested')
            ->with('book')
            ->get();

        // Get recent transactions (returns/rejects)
        $transactions = Transaction::where('student_id', $student->id)
            ->whereIn('status', ['returned', 'rejected'])
            ->with('book')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'transaction',
                    'book_title' => $item->book->title,
                    'status' => $item->status,
                    'date' => $item->updated_at,
                    'book' => $item->book
                ];
            });

        // Get recent reading activities
        $activities = ActivityLog::where('student_id', $student->id)
            ->with('book')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'activity',
                    'book_title' => $item->book->title,
                    'status' => $item->action_type === 'preview_abstract' ? 'Previewed' : 'Read Digital',
                    'date' => $item->created_at,
                    'book' => $item->book
                ];
            });

        // Merge and sort
        $borrowHistory = $transactions->concat($activities)->sortByDesc('date')->take(10);

        $stats = [
            'total_borrowed' => Transaction::where('student_id', $student->id)->where('status', 'returned')->count(),
            'total_read' => ActivityLog::where('student_id', $student->id)->count(),
            'currently_holding' => $currentlyBorrowed->count(),
            'pending' => $pendingRequests->count(),
            'overdue' => Transaction::where('student_id', $student->id)
                ->where('status', 'borrowed')
                ->where('due_date', '<', now())
                ->count(),
        ];

        return view('student.dashboard', compact('student', 'currentlyBorrowed', 'pendingRequests', 'borrowHistory', 'stats'));
    }
}
