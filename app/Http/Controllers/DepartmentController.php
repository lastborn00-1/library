<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments.
     */
    public function index()
    {
        $departments = Department::withCount('books')
            ->orderBy('name')
            ->get();

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created department in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'nullable|string|max:50|unique:departments,code',
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    /**
     * Show all books in a specific department.
     */
    public function show(Department $department)
    {
        $books = $department->books()->latest()->paginate(20);
        return view('departments.show', compact('department', 'books'));
    }

    /**
     * Show the form for editing the specified department.
     */
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified department in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'nullable|string|max:50|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully.');
    }

    /**
     * Soft-delete the specified department.
     */
    public function destroy(Department $department)
    {
        // Null out book associations first
        $department->books()->update(['department_id' => null]);
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted. Assigned books have been unlinked.');
    }
}
