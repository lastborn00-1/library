@extends('layouts.public')

@section('title', 'Repository Search - KWCHT')

@section('content')
<div class="bg-slate-50 py-8 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Repository Search (OPAC)</h1>
    </div>
</div>

<div class="py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Search Bar --}}
            <div class="mb-6 bg-white rounded-3xl p-6 shadow-sm border border-slate-100 text-center">
                <h3 class="text-2xl font-black text-slate-800 mb-2">Search Student Projects</h3>
                <p class="text-slate-500 mb-6">Browse through the digital archives of final-year projects and theses.</p>
                <form action="{{ route('repository.search') }}" method="GET" class="max-w-2xl mx-auto">
                    <div class="relative flex items-center">
                        <div class="absolute left-4 pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="q" value="{{ request('q') }}"
                               placeholder="Search by title, author, keyword..."
                               class="w-full pl-11 pr-28 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 text-sm shadow-sm transition outline-none">
                        <button type="submit" class="absolute right-2 px-5 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            {{-- Toolbar: Result count + View toggle --}}
            <div class="flex items-center justify-between mb-4 px-1">
                <p class="text-sm text-slate-500 font-medium">
                    @if(request()->has('q'))
                        Results for "<span class="font-bold text-slate-800">{{ request('q') }}</span>" &mdash; {{ $projects->total() }} found
                    @else
                        Showing all {{ $projects->total() }} projects
                    @endif
                </p>

                {{-- View Toggle Buttons --}}
                <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl">
                    <button id="btn-grid" onclick="setView('grid')"
                            class="view-btn p-2 rounded-lg bg-white shadow-sm text-indigo-600 transition"
                            title="Grid View">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </button>
                    <button id="btn-list" onclick="setView('list')"
                            class="view-btn p-2 rounded-lg text-slate-400 transition hover:text-slate-600"
                            title="List View">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- GRID VIEW --}}
            <div id="view-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($projects as $project)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition flex flex-col h-full">
                        <div class="mb-3">
                            <span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase border border-indigo-100 mb-2 inline-block">
                                {{ $project->department_name ?? 'Student Project' }}
                            </span>
                            <h3 class="text-base font-bold text-slate-800 line-clamp-2 leading-tight">{{ $project->title }}</h3>
                            <p class="text-xs text-slate-500 mt-1 font-medium">
                                @foreach($project->authors as $author)
                                    {{ $author->student_name }} <span class="text-slate-400">({{ $author->matric_number }})</span>{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </p>
                        </div>
                        <p class="text-sm text-slate-500 line-clamp-3 mb-4 flex-grow">{{ $project->abstract ?? 'No abstract provided.' }}</p>
                        <div class="mt-auto flex items-center justify-between pt-3 border-t border-slate-50">
                            <span class="text-[10px] font-semibold text-slate-400 uppercase">{{ $project->academic_session ?? '' }}</span>
                            @if($project->pdf_path)
                                <button onclick="openPdfModal('{{ route('repository.projects.view', $project) }}', '{{ addslashes($project->title) }}')"
                                        class="px-4 py-1.5 bg-emerald-50 text-emerald-600 text-xs font-bold uppercase rounded-xl hover:bg-emerald-100 border border-emerald-100 transition flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Read PDF
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-slate-400 italic bg-white rounded-3xl border border-dashed border-slate-200">
                        No projects found.
                    </div>
                @endforelse
            </div>

            {{-- LIST VIEW --}}
            <div id="view-list" class="hidden bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                @forelse ($projects as $project)
                    <div class="flex items-center gap-5 px-6 py-4 border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition group">
                        {{-- Icon --}}
                        <div class="w-10 h-12 flex-shrink-0 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500 border border-indigo-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>

                        {{-- Details --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-slate-800 truncate">{{ $project->title }}</h3>
                            <p class="text-xs text-slate-500 mt-0.5">
                                @foreach($project->authors as $author)
                                    {{ $author->student_name }} <span class="text-slate-400">({{ $author->matric_number }})</span>{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </p>
                            <p class="text-xs text-slate-400 line-clamp-1 mt-0.5">{{ $project->abstract ?? 'No abstract provided.' }}</p>
                        </div>

                        {{-- Meta --}}
                        <div class="hidden md:flex flex-col items-end gap-1 text-right flex-shrink-0">
                            <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">{{ $project->department_name ?? 'N/A' }}</span>
                            <span class="text-[10px] text-slate-400">{{ $project->academic_session ?? '' }}</span>
                        </div>

                        {{-- Action --}}
                        <div class="flex-shrink-0">
                            @if($project->pdf_path)
                                <button onclick="openPdfModal('{{ route('repository.projects.view', $project) }}', '{{ addslashes($project->title) }}')"
                                        class="px-4 py-2 bg-emerald-50 text-emerald-600 text-xs font-bold uppercase rounded-xl hover:bg-emerald-100 border border-emerald-100 transition flex items-center gap-1 whitespace-nowrap">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Read PDF
                                </button>
                            @else
                                <span class="text-[10px] text-slate-300 uppercase font-bold">No PDF</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-16 text-center text-slate-400 italic">
                        No projects found.
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $projects->links() }}
            </div>
        </div>
    </div>

    {{-- PDF Viewer Modal --}}
    <div id="pdf-modal" class="fixed inset-0 z-50 hidden" aria-modal="true" role="dialog">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closePdfModal()"></div>
        <div class="relative flex flex-col w-full h-full max-w-5xl mx-auto my-4 sm:my-8 bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 bg-slate-800 text-white flex-shrink-0">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span id="pdf-modal-title" class="font-bold text-sm truncate max-w-md"></span>
                </div>
                <button onclick="closePdfModal()" class="p-2 rounded-lg hover:bg-white/10 transition" title="Close">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="flex-1 overflow-hidden">
                <iframe id="pdf-frame" src="" class="w-full h-full border-0" title="PDF Viewer"></iframe>
            </div>
            <div class="px-6 py-2 bg-slate-50 border-t border-slate-200 flex-shrink-0">
                <p class="text-xs text-slate-400 text-center">This document is for reading only. Downloading is not permitted.</p>
            </div>
        </div>
    </div>

    <script>
        // ---- View Toggle ----
        function setView(view) {
            const grid = document.getElementById('view-grid');
            const list = document.getElementById('view-list');
            const btnGrid = document.getElementById('btn-grid');
            const btnList = document.getElementById('btn-list');

            if (view === 'grid') {
                grid.classList.remove('hidden');
                list.classList.add('hidden');
                btnGrid.classList.add('bg-white', 'shadow-sm', 'text-indigo-600');
                btnGrid.classList.remove('text-slate-400');
                btnList.classList.remove('bg-white', 'shadow-sm', 'text-indigo-600');
                btnList.classList.add('text-slate-400');
            } else {
                list.classList.remove('hidden');
                grid.classList.add('hidden');
                btnList.classList.add('bg-white', 'shadow-sm', 'text-indigo-600');
                btnList.classList.remove('text-slate-400');
                btnGrid.classList.remove('bg-white', 'shadow-sm', 'text-indigo-600');
                btnGrid.classList.add('text-slate-400');
            }

            localStorage.setItem('repo_view', view);
        }

        // Restore saved preference on load
        document.addEventListener('DOMContentLoaded', function () {
            const saved = localStorage.getItem('repo_view') || 'grid';
            setView(saved);
        });

        // ---- PDF Modal ----
        function openPdfModal(url, title) {
            document.getElementById('pdf-frame').src = url;
            document.getElementById('pdf-modal-title').textContent = title;
            document.getElementById('pdf-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePdfModal() {
            document.getElementById('pdf-modal').classList.add('hidden');
            document.getElementById('pdf-frame').src = '';
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closePdfModal();
        });
    </script>
@endsection
