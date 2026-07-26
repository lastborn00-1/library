<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentRegisterController extends Controller
{
    public function create()
    {
        $regEnabled = \App\Models\Setting::where('key', 'student_registration_enabled')->value('value') !== '0';
        $departments = \App\Models\Department::active()->orderBy('name')->get();
        return view('auth.student-register', compact('departments', 'regEnabled'));
    }

    public function store(Request $request)
    {
        $regEnabled = \App\Models\Setting::where('key', 'student_registration_enabled')->value('value') !== '0';
        if (!$regEnabled) {
            return back()->withErrors(['registration' => 'Student registration is currently closed. Please contact the library administration.'])->withInput();
        }

        $request->validate([
            'first_name'    => 'required|string|max:100',
            'surname'       => 'required|string|max:100',
            'other_name'    => 'nullable|string|max:100',
            'matric_number' => 'required|string|max:50|unique:students,student_id',
            'department'    => 'required|string|max:100',
            'class'         => 'required|string|max:100',
            'phone'         => 'nullable|string|max:20',
        ], [
            'matric_number.unique' => 'This matric number is already registered.',
        ]);

        $firstName = trim($request->first_name);
        $fullName  = trim($firstName . ' ' . trim($request->surname) . ($request->filled('other_name') ? ' ' . trim($request->other_name) : ''));

        // Create the user account — matric number as username/email surrogate, First Name as default password
        $user = User::create([
            'name'     => $fullName,
            'email'    => strtolower($request->matric_number) . '@kwcht.student',
            'username' => $request->matric_number,
            'password' => Hash::make($firstName),
            'role'     => 'student',
        ]);

        // Create the student record linked to the user
        Student::create([
            'user_id'    => $user->id,
            'name'       => $fullName,
            'student_id' => $request->matric_number,
            'department' => $request->department,
            'class'      => $request->class,
            'phone'      => $request->phone,
        ]);

        // Log them in automatically
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Account created! Welcome to KWCHT Library.');
    }
}
