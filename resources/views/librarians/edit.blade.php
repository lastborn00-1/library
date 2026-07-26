<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('librarians.index') }}" class="text-slate-500 hover:text-slate-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">Edit Librarian</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-700 text-sm">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                    <div class="w-16 h-16 rounded-full overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400">
                        @if($librarian->profile_photo)
                            <img src="{{ asset('storage/' . $librarian->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        @endif
                    </div>
                    <div>
                        <div class="font-bold text-slate-800 text-lg">{{ $librarian->user->name }}</div>
                        <div class="text-sm text-slate-500">{{ $librarian->user->email }}</div>
                    </div>
                </div>

                <form action="{{ route('librarians.update', $librarian) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $librarian->phone) }}"
                                placeholder="+234..."
                                class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Status</label>
                            <select name="status" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                                <option value="active" {{ $librarian->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $librarian->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Profile Photo</label>
                        <div class="flex items-center gap-4">
                            @if($librarian->profile_photo)
                                <img src="{{ asset('storage/' . $librarian->profile_photo) }}" class="w-12 h-12 rounded-full object-cover border border-slate-200">
                            @endif
                            <input type="file" name="profile_photo" accept="image/*"
                                class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                        <a href="{{ route('librarians.index') }}" class="px-6 py-3 border border-slate-200 text-slate-600 font-semibold rounded-xl hover:bg-slate-50 transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
