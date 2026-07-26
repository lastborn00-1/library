<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Department;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('department');

        if ($request->has('type')) {
            $query->where('book_type', $request->type);
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        $books = $query->latest()->get();
        $departments = Department::active()->orderBy('name')->get();
        return view('books.index', compact('books', 'departments'));
    }

    public function create()
    {
        $departments = Department::active()->orderBy('name')->get();
        return view('books.create', compact('departments'));
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_type'     => 'required|in:physical,digital,hybrid',
            'title'         => 'required|string|max:255',
            'author'        => 'required|string|max:255',
            'isbn'          => 'nullable|string|max:50',
            'category'      => 'required|string',
            'department_id' => 'nullable|exists:departments,id',
            'quantity'      => 'nullable|integer|min:0',
            'shelf_location'=> 'nullable|string|max:100',
            'cover_image'   => 'nullable|image|max:2048',
            'pdf_file'      => 'nullable|mimes:pdf|max:102400',
            'abstract'      => 'nullable|string',
        ]);

        if ($validated['book_type'] === 'digital') {
            $validated['quantity'] = 0;
            $validated['available_quantity'] = 0;
        } else {
            $validated['available_quantity'] = $validated['quantity'] ?? 0;
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $validated['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
        }

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }

    public function edit(Book $book)
    {
        $departments = Department::active()->orderBy('name')->get();
        return view('books.edit', compact('book', 'departments'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'book_type'     => 'required|in:physical,digital,hybrid',
            'title'         => 'required|string|max:255',
            'author'        => 'required|string|max:255',
            'isbn'          => 'nullable|string|max:50',
            'category'      => 'required|string',
            'department_id' => 'nullable|exists:departments,id',
            'quantity'      => 'nullable|integer|min:0',
            'shelf_location'=> 'nullable|string|max:100',
            'cover_image'   => 'nullable|image|max:2048',
            'pdf_file'      => 'nullable|mimes:pdf|max:102400',
            'abstract'      => 'nullable|string',
        ]);

        if ($validated['book_type'] === 'digital') {
            $validated['quantity'] = 0;
            $validated['available_quantity'] = 0;
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $validated['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
