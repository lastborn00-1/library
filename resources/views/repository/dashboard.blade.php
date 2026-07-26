<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">Institutional Repository</h2>
                <p class="text-xs text-slate-400 mt-0.5">Kwara State College of Health Technology, Offa</p>
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

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Stat Row --}}
            <div class="grid grid-cols-3 gap-4">
                {{-- Total Projects --}}
                <div class="bg-white rounded-xl border border-slate-100 shadow-sm px-5 py-4 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Total Projects</p>
                        <p class="text-2xl font-black text-slate-800 leading-none mt-0.5">{{ $totalProjects }}</p>
                    </div>
                </div>

                {{-- Departments --}}
                <div class="bg-white rounded-xl border border-slate-100 shadow-sm px-5 py-4 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Departments</p>
                        <p class="text-2xl font-black text-slate-800 leading-none mt-0.5">{{ $totalDepartments }}</p>
                    </div>
                </div>

                {{-- Pending --}}
                <div class="bg-white rounded-xl border border-slate-100 shadow-sm px-5 py-4 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Pending Review</p>
                        <p class="text-2xl font-black text-slate-800 leading-none mt-0.5">{{ $pendingProjects }}</p>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">

                {{-- Sidebar Quick Actions --}}
                <div class="lg:col-span-1 space-y-2">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest px-1 mb-3">Quick Actions</p>

                    <a href="{{ route('repository.projects.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 bg-white rounded-lg border border-slate-100 hover:border-indigo-400 hover:bg-indigo-50/40 transition group">
                        <div class="w-7 h-7 rounded-md bg-slate-100 group-hover:bg-indigo-100 flex items-center justify-center flex-shrink-0 transition">
                            <svg class="w-4 h-4 text-slate-500 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-slate-700 group-hover:text-indigo-700">All Projects</div>
                            <div class="text-xs text-slate-400">Browse & manage</div>
                        </div>
                    </a>

                    <a href="{{ route('repository.projects.create') }}"
                       class="flex items-center gap-3 px-3 py-2.5 bg-white rounded-lg border border-slate-100 hover:border-indigo-400 hover:bg-indigo-50/40 transition group">
                        <div class="w-7 h-7 rounded-md bg-slate-100 group-hover:bg-indigo-100 flex items-center justify-center flex-shrink-0 transition">
                            <svg class="w-4 h-4 text-slate-500 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-slate-700 group-hover:text-indigo-700">Upload Project</div>
                            <div class="text-xs text-slate-400">Add new PDF</div>
                        </div>
                    </a>

                    <a href="{{ route('repository.search') }}"
                       class="flex items-center gap-3 px-3 py-2.5 bg-white rounded-lg border border-slate-100 hover:border-indigo-400 hover:bg-indigo-50/40 transition group">
                        <div class="w-7 h-7 rounded-md bg-slate-100 group-hover:bg-indigo-100 flex items-center justify-center flex-shrink-0 transition">
                            <svg class="w-4 h-4 text-slate-500 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-slate-700 group-hover:text-indigo-700">Search OPAC</div>
                            <div class="text-xs text-slate-400">Student portal</div>
                        </div>
                    </a>

                    <a href="{{ route('repository.statistics') }}"
                       class="flex items-center gap-3 px-3 py-2.5 bg-white rounded-lg border border-slate-100 hover:border-indigo-400 hover:bg-indigo-50/40 transition group">
                        <div class="w-7 h-7 rounded-md bg-slate-100 group-hover:bg-indigo-100 flex items-center justify-center flex-shrink-0 transition">
                            <svg class="w-4 h-4 text-slate-500 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-slate-700 group-hover:text-indigo-700">Statistics</div>
                            <div class="text-xs text-slate-400">Insights & reports</div>
                        </div>
                    </a>
                </div>

                {{-- Recent Projects Table --}}
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between">
                            <h3 class="text-sm font-bold text-slate-700">Recently Uploaded Projects</h3>
                            <a href="{{ route('repository.projects.index') }}"
                               class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">View All &rarr;</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-slate-50 text-slate-400 text-[11px] uppercase tracking-wider border-b border-slate-100">
                                    <tr>
                                        <th class="px-5 py-3 font-semibold">Title</th>
                                        <th class="px-5 py-3 font-semibold">Authors</th>
                                        <th class="px-5 py-3 font-semibold">Dept.</th>
                                        <th class="px-5 py-3 font-semibold">Status</th>
                                        <th class="px-5 py-3 font-semibold">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse ($recentProjects as $project)
                                        <tr class="hover:bg-slate-50/60 transition">
                                            <td class="px-5 py-3">
                                                <a href="{{ route('repository.projects.show', $project) }}"
                                                   class="font-semibold text-slate-800 hover:text-indigo-600 transition leading-snug block">
                                                    {{ Str::limit($project->title, 45) }}
                                                </a>
                                            </td>
                                            <td class="px-5 py-3 text-slate-500 text-xs">
                                                {{ Str::limit($project->authors->pluck('student_name')->join(', '), 30) }}
                                            </td>
                                            <td class="px-5 py-3 text-slate-500 text-xs">
                                                {{ Str::limit($project->department_name ?? '—', 20) }}
                                            </td>
                                            <td class="px-5 py-3">
                                                @if($project->status == 'approved')
                                                    <span class="inline-flex px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase border border-emerald-100">Approved</span>
                                                @elseif($project->status == 'rejected')
                                                    <span class="inline-flex px-2 py-0.5 rounded-md bg-rose-50 text-rose-600 text-[10px] font-bold uppercase border border-rose-100">Rejected</span>
                                                @else
                                                    <span class="inline-flex px-2 py-0.5 rounded-md bg-amber-50 text-amber-600 text-[10px] font-bold uppercase border border-amber-100">Pending</span>
                                                @endif
                                            </td>
                                            <td class="px-5 py-3 text-slate-400 text-xs whitespace-nowrap">
                                                {{ $project->created_at->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-5 py-10 text-center text-slate-400 italic text-sm">
                                                No projects uploaded yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
