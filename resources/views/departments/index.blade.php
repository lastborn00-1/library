<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Departments') }}
            </h2>
            <a href="{{ route('departments.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-sm text-sm">
                + Add Department
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if($departments->isEmpty())
                <div class="text-center py-24 text-slate-500 bg-white rounded-3xl border border-slate-100 shadow-sm">
                    <svg class="w-16 h-16 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <p class="text-lg font-semibold text-slate-400 mb-2">No departments yet</p>
                    <p class="text-sm text-slate-400 mb-6">Create your first department to start classifying books.</p>
                    <a href="{{ route('departments.create') }}" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition">
                        Create First Department
                    </a>
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-sm border-b border-slate-100">
                                <th class="py-4 px-6 font-semibold">Department Name</th>
                                <th class="py-4 px-6 font-semibold">Code</th>
                                <th class="py-4 px-6 font-semibold">Description</th>
                                <th class="py-4 px-6 font-semibold text-center">Books</th>
                                <th class="py-4 px-6 font-semibold text-center">Status</th>
                                <th class="py-4 px-6 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $dept)
                                <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6 font-semibold text-slate-900">
                                        <a href="{{ route('departments.show', $dept) }}" class="hover:text-indigo-600 transition">
                                            {{ $dept->name }}
                                        </a>
                                    </td>
                                    <td class="py-4 px-6 text-slate-500 text-sm">
                                        {{ $dept->code ?: '—' }}
                                    </td>
                                    <td class="py-4 px-6 text-slate-500 text-sm max-w-xs truncate">
                                        {{ Str::limit($dept->description, 60) ?: '—' }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <a href="{{ route('departments.show', $dept) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-50 text-indigo-700 font-bold text-sm hover:bg-indigo-100 transition">
                                            {{ $dept->books_count }}
                                        </a>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($dept->status === 'active')
                                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full">Active</span>
                                        @else
                                            <span class="px-3 py-1 bg-slate-100 text-slate-500 text-xs font-bold rounded-full">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('departments.edit', $dept) }}" class="px-3 py-1.5 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-200 transition">Edit</a>
                                            <form action="{{ route('departments.destroy', $dept) }}" method="POST" onsubmit="return confirm('Delete this department? Books will be unlinked.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-rose-50 text-rose-600 text-xs font-bold rounded-lg hover:bg-rose-100 transition">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
