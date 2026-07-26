<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Transaction::with(['student', 'book', 'librarian']);

        if ($user->role === 'student') {
            $query->where('student_id', $user->student->id);
        }

        $transactions = $query->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function requests()
    {
        $this->authorizeLibrarian();
        $transactions = Transaction::with(['student', 'book'])
            ->whereIn('status', ['requested', 'pending_return'])
            ->latest()
            ->get();
        return view('transactions.requests', compact('transactions'));
    }

    public function borrow(Book $book)
    {
        $user = Auth::user();
        if ($user->role !== 'student' || !$user->student) {
            return back()->with('error', 'Only registered students can borrow books.');
        }

        if ($book->book_type === 'digital') {
            return back()->with('error', 'Digital books can only be read online.');
        }

        if ($book->available_quantity <= 0) {
            return back()->with('error', 'This book is currently out of stock.');
        }

        // Check for existing active/pending transaction
        $exists = Transaction::where('student_id', $user->student->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['requested', 'borrowed'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already have an active request or borrow for this book.');
        }

        Transaction::create([
            'student_id' => $user->student->id,
            'book_id' => $book->id,
            'status' => 'requested',
        ]);

        return back()->with('success', 'Borrow request submitted. Please wait for librarian approval.');
    }

    public function approve(Transaction $transaction)
    {
        $this->authorizeLibrarian();
        
        if ($transaction->status !== 'requested') {
            return back()->with('error', 'This transaction cannot be approved.');
        }

        $book = $transaction->book;
        if ($book->available_quantity <= 0) {
            return back()->with('error', 'No copies available to fulfill this request.');
        }

        $transaction->update([
            'librarian_id' => Auth::id(),
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14), // Default 2 weeks
            'status' => 'borrowed',
        ]);

        $book->decrement('available_quantity');

        return back()->with('success', 'Borrow request approved.');
    }

    public function reject(Transaction $transaction)
    {
        $this->authorizeLibrarian();
        
        if ($transaction->status !== 'requested') {
            return back()->with('error', 'This transaction cannot be rejected.');
        }

        $transaction->update(['status' => 'rejected']);

        return back()->with('success', 'Borrow request rejected.');
    }

    public function returnBook(Transaction $transaction)
    {
        $user = Auth::user();
        $isStudent = $user->role === 'student';

        if ($isStudent) {
            if ($transaction->student_id !== $user->student->id) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            $this->authorizeLibrarian();
        }

        if ($transaction->status !== 'borrowed') {
            return back()->with('error', 'This book has not been borrowed or was already returned.');
        }

        if ($isStudent) {
            $transaction->update([
                'status' => 'pending_return',
            ]);
            return back()->with('success', 'Return requested. Please submit the physical book to the librarian.');
        } else {
            $transaction->update([
                'returned_at' => now(),
                'status' => 'returned',
            ]);
            $transaction->book->increment('available_quantity');
            return back()->with('success', 'Book marked as returned.');
        }
    }

    public function confirmReturn(Transaction $transaction)
    {
        $this->authorizeLibrarian();

        if ($transaction->status !== 'pending_return') {
            return back()->with('error', 'This transaction is not pending return.');
        }

        $transaction->update([
            'returned_at' => now(),
            'status' => 'returned',
        ]);

        $transaction->book->increment('available_quantity');

        return back()->with('success', 'Return confirmed.');
    }

    private function authorizeLibrarian()
    {
        if (!in_array(Auth::user()->role, ['librarian', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}
