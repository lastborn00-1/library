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
        return view('auth.student-register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'matric_number' => 'required|string|max:50|unique:students,student_id',
            'department'    => 'required|string|max:100',
            'class'         => 'required|string|max:100',
            'phone'         => 'nullable|string|max:20',
        ], [
            'matric_number.unique' => 'This matric number is already registered.',
        ]);

        // Extract first name as the default password
        $firstName = explode(' ', trim($request->name))[0];

        // Create the user account — matric number as username/email surrogate
        $user = User::create([
            'name'     => $request->name,
            'email'    => strtolower($request->matric_number) . '@kwcht.student',
            'username' => $request->matric_number,
            'password' => Hash::make($firstName),
            'role'     => 'student',
        ]);

        // Create the student record linked to the user
        Student::create([
            'user_id'    => $user->id,
            'name'       => $request->name,
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
