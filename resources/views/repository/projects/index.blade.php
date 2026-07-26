<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">Manage Projects</h2>
                <p class="text-xs text-slate-400 mt-0.5">Institutional Repository — Final Year Projects Archive</p>
            </div>
            <a href="{{ route('repository.projects.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Upload Project
            </a>
        </div>
    </x-slot>

    <div class="py-6" x-data="{ view: localStorage.getItem('repoView') || 'list' }" x-init="$watch('view', v => localStorage.setItem('repoView', v))">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="flex items-center gap-3 p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm font-medium">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Toolbar --}}
            <div class="flex items-center justify-between gap-3">
                {{-- Search --}}
                <form method="GET" action="{{ route('repository.projects.index') }}" class="flex-1 max-w-md">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="q" value="{{ request('q') }}"
                               placeholder="Search projects..."
                               class="w-full pl-9 pr-24 py-2 text-sm bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition outline-none">
                        <button type="submit"
                                class="absolute right-1.5 top-1/2 -translate-y-1/2 px-3 py-1 bg-indigo-600 text-white text-xs font-semibold rounded-md hover:bg-indigo-700 transition">
                            Search
                        </button>
                    </div>
                </form>

                {{-- View Toggle --}}
                <div class="flex items-center bg-white border border-slate-200 rounded-lg p-1 gap-1">
                    <button @click="view = 'grid'"
                            :class="view === 'grid' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-400 hover:text-slate-600'"
                            class="p-1.5 rounded-md transition" title="Grid view">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </button>
                    <button @click="view = 'list'"
                            :class="view === 'list' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-400 hover:text-slate-600'"
                            class="p-1.5 rounded-md transition" title="List view">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- ==================== GRID VIEW ==================== --}}
            <div x-show="view === 'grid'" x-cloak>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($projects as $project)
                        <div class="bg-white rounded-xl border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition flex flex-col overflow-hidden group">
                            {{-- Card Header --}}
                            <div class="px-5 pt-5 pb-3 flex-1">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    @if($project->status === 'approved')
                                        <span class="inline-flex px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase border border-emerald-100 flex-shrink-0">Approved</span>
                                    @elseif($project->status === 'rejected')
                                        <span class="inline-flex px-2 py-0.5 rounded-md bg-rose-50 text-rose-600 text-[10px] font-bold uppercase border border-rose-100 flex-shrink-0">Rejected</span>
                                    @else
                                        <span class="inline-flex px-2 py-0.5 rounded-md bg-amber-50 text-amber-600 text-[10px] font-bold uppercase border border-amber-100 flex-shrink-0">Pending</span>
                                    @endif
                                    <span class="text-[10px] text-slate-400 font-medium">{{ ucfirst($project->visibility) }}</span>
                                </div>

                                <h3 class="font-bold text-slate-800 text-sm leading-snug line-clamp-2 group-hover:text-indigo-700 transition mb-1">
                                    {{ $project->title }}
                                </h3>
                                <p class="text-xs text-slate-400 line-clamp-1">
                                    By: {{ $project->authors->pluck('student_name')->join(', ') }}
                                </p>

                                @if($project->abstract)
                                    <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">{{ $project->abstract }}</p>
                                @endif
                            </div>

                            {{-- Meta --}}
                            <div class="px-5 py-2.5 bg-slate-50 border-t border-slate-100 text-[11px] text-slate-400 flex items-center gap-3">
                                @if($project->department_name)
                                    <span class="flex items-center gap-1 truncate">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                                        {{ Str::limit($project->department_name, 22) }}
                                    </span>
                                @endif
                                @if($project->academic_session)
                                    <span class="flex items-center gap-1 flex-shrink-0">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $project->academic_session }}
                                    </span>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('repository.projects.show', $project) }}"
                                       class="text-xs text-slate-500 hover:text-indigo-600 font-semibold transition flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        View
                                    </a>
                                    @if($project->pdf_path)
                                        <a href="{{ route('repository.projects.download', $project) }}"
                                           class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold transition flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            PDF
                                        </a>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('repository.projects.edit', $project) }}"
                                       class="px-2 py-1.5 text-xs font-semibold text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-md transition flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('repository.projects.destroy', $project) }}" method="POST"
                                          onsubmit="return confirm('Delete this project permanently?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-2 py-1.5 text-xs font-semibold text-slate-600 hover:text-rose-600 hover:bg-rose-50 rounded-md transition flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-xl border border-dashed border-slate-200">
                            <svg class="w-10 h-10 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="text-sm font-medium">No projects found.</p>
                            <a href="{{ route('repository.projects.create') }}" class="mt-2 inline-block text-xs text-indigo-600 font-semibold hover:underline">Upload the first project →</a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- ==================== LIST VIEW ==================== --}}
            <div x-show="view === 'list'" x-cloak>
                <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 border-b border-slate-100 text-[11px] text-slate-400 uppercase tracking-wider">
                            <tr>
                                <th class="px-5 py-3 font-semibold">Title & Authors</th>
                                <th class="px-5 py-3 font-semibold">Department / Session</th>
                                <th class="px-5 py-3 font-semibold">Status</th>
                                <th class="px-5 py-3 font-semibold">Visibility</th>
                                <th class="px-5 py-3 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($projects as $project)
                                <tr class="hover:bg-slate-50/60 transition group">
                                    <td class="px-5 py-3.5 max-w-xs">
                                        <a href="{{ route('repository.projects.show', $project) }}"
                                           class="font-semibold text-slate-800 hover:text-indigo-600 transition leading-snug block">
                                            {{ Str::limit($project->title, 55) }}
                                        </a>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ Str::limit($project->authors->pluck('student_name')->join(', '), 40) }}</p>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <p class="text-xs font-medium text-slate-600">{{ $project->department_name ?? '—' }}</p>
                                        <p class="text-xs text-slate-400">{{ $project->academic_session ?? '' }}</p>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if($project->status === 'approved')
                                            <span class="inline-flex px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase border border-emerald-100">Approved</span>
                                        @elseif($project->status === 'rejected')
                                            <span class="inline-flex px-2 py-0.5 rounded-md bg-rose-50 text-rose-600 text-[10px] font-bold uppercase border border-rose-100">Rejected</span>
                                        @else
                                            <span class="inline-flex px-2 py-0.5 rounded-md bg-amber-50 text-amber-600 text-[10px] font-bold uppercase border border-amber-100">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-xs text-slate-500 font-medium">{{ ucfirst($project->visibility) }}</td>
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center justify-end gap-1.5">
                                            @if($project->pdf_path)
                                                <a href="{{ route('repository.projects.download', $project) }}"
                                                   class="p-1.5 text-indigo-500 hover:text-indigo-700 hover:bg-indigo-50 rounded-md transition" title="Download PDF">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                </a>
                                            @endif
                                            <a href="{{ route('repository.projects.edit', $project) }}"
                                               class="px-2.5 py-1.5 text-xs font-semibold text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-md transition flex items-center gap-1" title="Edit">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('repository.projects.destroy', $project) }}" method="POST"
                                                  onsubmit="return confirm('Delete this project permanently?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        class="px-2.5 py-1.5 text-xs font-semibold text-slate-600 hover:text-rose-600 hover:bg-rose-50 rounded-md transition flex items-center gap-1" title="Delete">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-12 text-center text-slate-400 text-sm italic">No projects found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if($projects->hasPages())
                <div class="pt-1">
                    {{ $projects->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
