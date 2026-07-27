@php
    if (!isset($regEnabled)) {
        $regEnabled = \App\Models\Setting::where('key', 'student_registration_enabled')->value('value') !== '0';
    }
@endphp
@extends('layouts.public')

@section('content')
<div class="py-12 md:py-16 bg-slate-50 flex-grow flex items-center justify-center relative" style="background-image: url('{{ asset('loginimage.png') }}'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-black/20"></div>

    <div class="relative z-10 w-full max-w-lg mx-auto px-4 sm:px-6">
        <div class="bg-white/95 backdrop-blur-md p-8 sm:p-10 rounded-2xl shadow-2xl border border-slate-100">
            <!-- School Logo -->
            <div class="flex flex-col items-center mb-6">
                <a href="{{ url('/') }}">
                    <x-application-logo class="h-20 w-auto" />
                </a>
            </div>

            @if(!$regEnabled)
                <!-- Registration Closed Notice -->
                <div class="text-center py-4">
                    <div class="w-16 h-16 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-rose-100 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    
                    <h2 class="text-2xl font-black text-slate-900 mb-2">Student Registration Closed</h2>
                    <p class="text-slate-600 text-sm leading-relaxed max-w-sm mx-auto mb-6">
                        Online self-registration is currently turned off by the library administration. If you need a new library account, please contact the Chief Librarian's office.
                    </p>

                    <div class="space-y-3">
                        <a href="{{ route('login') }}" class="block w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl transition text-center shadow-md">
                            Log In to Existing Account
                        </a>
                        <a href="{{ url('/') }}" class="block w-full py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition text-center">
                            Return to Homepage
                        </a>
                    </div>
                </div>
            @else
                <!-- Header -->
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-black text-slate-900">Create Library Account</h2>
                    <p class="text-sm text-slate-500 mt-1">Use your matric number and first name to register.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-rose-50 border border-rose-200 rounded-xl text-rose-700 text-sm">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('student.register.store') }}" class="space-y-5">
                    @csrf

                    <!-- Name Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-slate-700 mb-1">
                                First Name <span class="text-rose-500">*</span>
                            </label>
                            <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus
                                   class="block w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition shadow-sm sm:text-sm"
                                   placeholder="e.g. Abdulrasheed">
                            <p class="text-[11px] text-amber-700 font-semibold mt-1">🔑 This First Name will be your default password!</p>
                        </div>
                        <div>
                            <label for="surname" class="block text-sm font-semibold text-slate-700 mb-1">
                                Surname / Last Name <span class="text-rose-500">*</span>
                            </label>
                            <input id="surname" type="text" name="surname" value="{{ old('surname') }}" required
                                   class="block w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition shadow-sm sm:text-sm"
                                   placeholder="e.g. Yahaya">
                        </div>
                    </div>

                    <div>
                        <label for="other_name" class="block text-sm font-semibold text-slate-700 mb-1">
                            Other Name <span class="text-slate-400 font-normal">(optional)</span>
                        </label>
                        <input id="other_name" type="text" name="other_name" value="{{ old('other_name') }}"
                               class="block w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition shadow-sm sm:text-sm"
                               placeholder="e.g. Olanrewaju">
                    </div>

                    <!-- Matric Number -->
                    <div>
                        <label for="matric_number" class="block text-sm font-semibold text-slate-700 mb-1">Matric Number <span class="text-rose-500">*</span></label>
                        <input id="matric_number" type="text" name="matric_number" value="{{ old('matric_number') }}" required
                               class="block w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition shadow-sm sm:text-sm"
                               placeholder="e.g. KWCHT/2024/001">
                        <p class="text-xs text-slate-500 mt-1.5">This will be your <strong>username</strong> to log in.</p>
                    </div>

                    <!-- Department & Level -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="department" class="block text-sm font-semibold text-slate-700 mb-1">Department <span class="text-rose-500">*</span></label>
                            @php
                                if (!isset($departments)) {
                                    $departments = \App\Models\Department::active()->orderBy('name')->get();
                                }
                            @endphp
                            <select id="department" name="department" required
                                    class="block w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition shadow-sm sm:text-sm">
                                <option value="">-- Select Department --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->name }}" {{ old('department') == $dept->name ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="class" class="block text-sm font-semibold text-slate-700 mb-1">Level / Class <span class="text-rose-500">*</span></label>
                            <input id="class" type="text" name="class" value="{{ old('class') }}" required
                                   class="block w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition shadow-sm sm:text-sm"
                                   placeholder="e.g. 300 Level">
                        </div>
                    </div>

                    <!-- Phone (Optional) -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1">Phone Number <span class="text-slate-400 font-normal">(optional)</span></label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                               class="block w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-900 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition shadow-sm sm:text-sm"
                               placeholder="+234...">
                    </div>

                    <!-- Info box about default password -->
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 text-xs text-amber-800">
                        <strong>Default Password:</strong> Your first name (e.g. if your name is <em>Abdulrasheed Yahaya</em>, your password is <em>Abdulrasheed</em>). You can change it after logging in.
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600 transition">
                            Create Account
                        </button>
                    </div>

                    <p class="text-center text-sm text-slate-500">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-emerald-700 font-semibold hover:underline">Log in</a>
                    </p>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
