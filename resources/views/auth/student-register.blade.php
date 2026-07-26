@php
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

if (request()->isMethod('post')) {
    // This is handled by the controller
}
@endphp
<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-900">Create Library Account</h2>
        <p class="text-sm text-slate-500 mt-1">Use your matric number and first name to register.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if ($errors->any())
        <div class="mb-4 p-3 bg-rose-50 border border-rose-200 rounded-lg text-rose-700 text-sm">
            <ul class="list-disc pl-4 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('student.register.store') }}" class="space-y-5">
        @csrf

        <!-- Full Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Full Name <span class="text-rose-500">*</span></label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="block w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition shadow-sm sm:text-sm"
                   placeholder="e.g. Abdulrasheed Yahaya">
        </div>

        <!-- Matric Number -->
        <div>
            <label for="matric_number" class="block text-sm font-semibold text-slate-700 mb-1">Matric Number <span class="text-rose-500">*</span></label>
            <input id="matric_number" type="text" name="matric_number" value="{{ old('matric_number') }}" required
                   class="block w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition shadow-sm sm:text-sm"
                   placeholder="e.g. KWCHT/2024/001">
            <p class="text-xs text-slate-500 mt-1.5">This will be your <strong>username</strong> to log in.</p>
        </div>

        <!-- Department & Level -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="department" class="block text-sm font-semibold text-slate-700 mb-1">Department <span class="text-rose-500">*</span></label>
                <input id="department" type="text" name="department" value="{{ old('department') }}" required
                       class="block w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition shadow-sm sm:text-sm"
                       placeholder="e.g. Nursing Science">
            </div>
            <div>
                <label for="class" class="block text-sm font-semibold text-slate-700 mb-1">Level / Class <span class="text-rose-500">*</span></label>
                <input id="class" type="text" name="class" value="{{ old('class') }}" required
                       class="block w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition shadow-sm sm:text-sm"
                       placeholder="e.g. 300 Level">
            </div>
        </div>

        <!-- Phone (Optional) -->
        <div>
            <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1">Phone Number <span class="text-slate-400 font-normal">(optional)</span></label>
            <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                   class="block w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-900 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition shadow-sm sm:text-sm"
                   placeholder="+234...">
        </div>

        <!-- Info box about default password -->
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 text-xs text-amber-800">
            <strong>Default Password:</strong> Your first name (e.g. if your name is <em>Abdulrasheed Yahaya</em>, your password is <em>Abdulrasheed</em>). You can change it after logging in.
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                Create Account
            </button>
        </div>

        <p class="text-center text-sm text-slate-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Log in</a>
        </p>
    </form>
</x-guest-layout>
