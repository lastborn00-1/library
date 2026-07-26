<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50|unique:students,student_id',
            'class' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Student registered successfully.');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50|unique:students,student_id,' . $student->id,
            'class' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
