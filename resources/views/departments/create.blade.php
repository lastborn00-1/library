<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('departments.index') }}" class="text-slate-500 hover:text-slate-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">Add New Department</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                <form action="{{ route('departments.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Department Name <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" required
                               value="{{ old('name') }}"
                               placeholder="e.g. Community Health"
                               class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('name')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="code" class="block text-sm font-bold text-slate-700 mb-2">Department Code <span class="text-slate-400 font-normal">(optional)</span></label>
                        <input type="text" id="code" name="code"
                               value="{{ old('code') }}"
                               placeholder="e.g. CHD"
                               class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('code')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Description <span class="text-slate-400 font-normal">(optional)</span></label>
                        <textarea id="description" name="description" rows="3"
                                  placeholder="Brief description of this department..."
                                  class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                        @error('description')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-bold text-slate-700 mb-2">Status <span class="text-rose-500">*</span></label>
                        <select id="status" name="status" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-sm">
                            Create Department
                        </button>
                        <a href="{{ route('departments.index') }}" class="px-6 py-3 text-slate-600 font-semibold hover:text-slate-800 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
