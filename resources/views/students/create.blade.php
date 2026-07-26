<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('students.index') }}" class="text-slate-400 hover:text-slate-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Register New Student') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-8 p-4 bg-rose-50 border border-rose-100 rounded-2xl text-rose-700 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('students.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Student Information</h3>
                    
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Full Name</label>
                            <input type="text" name="name" placeholder="e.g. Abdulrasheed Mohammed" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Matric Number</label>
                                <input type="text" name="student_id" placeholder="e.g. KW/CH/2026/001" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Class / Level</label>
                                <input type="text" name="class" placeholder="e.g. ND 1" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Department</label>
                                <input type="text" name="department" placeholder="e.g. CHEW" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Phone Number (Parent/Guardian)</label>
                            <input type="text" name="phone" placeholder="e.g. +234 801 234 5678" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('students.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition shadow-xl shadow-indigo-100">
                        Register Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
