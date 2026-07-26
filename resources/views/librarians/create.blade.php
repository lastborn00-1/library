<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('librarians.index') }}" class="text-slate-400 hover:text-slate-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Add New Librarian') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('librarians.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Account Information</h3>
                    
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Jane Smith" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                            @error('name') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="e.g. jane@kwcht.edu.ng" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                            @error('email') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Temporary Password</label>
                                <input type="password" name="password" placeholder="••••••••" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                                @error('password') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. +234 802 345 6789" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition">
                                @error('phone') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Public Profile Information</h3>
                    <p class="text-sm text-slate-500 mb-4">This information will be displayed on the public Staff page.</p>

                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Position</label>
                            <input type="text" name="position" value="{{ old('position') }}" placeholder="e.g. Librarian 1, Chief Librarian" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                            @error('position') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Qualifications (Optional)</label>
                            <input type="text" name="qualifications" value="{{ old('qualifications') }}" placeholder="e.g. BSc. Library Science, MLS" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition">
                            @error('qualifications') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Biography (Optional)</label>
                            <textarea name="bio" rows="4" placeholder="Brief professional biography..." class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition">{{ old('bio') }}</textarea>
                            @error('bio') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>


                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Profile Photo</h3>
                    <div class="space-y-2">
                        <input type="file" name="profile_photo" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                        @error('profile_photo') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('librarians.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition shadow-xl shadow-indigo-100">
                        Create Librarian
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
