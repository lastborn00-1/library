@extends('layouts.public')

@section('title', 'Past Examination Questions - ' . config('app.name'))

@section('content')
<div class="bg-slate-900 text-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-black mb-4">Past Examination Questions</h1>
        <p class="text-slate-300 text-lg max-w-2xl mx-auto">
            Browse, view, and download past examination papers across various departments, programs, and academic sessions.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Filter & Search Bar + View Toggle -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 mb-8">
        <form action="{{ route('past-questions.index') }}" method="GET" id="filterForm">
            <div class="flex flex-col md:flex-row gap-4 items-end">
                <!-- Search -->
                <div class="flex-1">
                    <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Search</label>
                    <input type="text" name="search" placeholder="Title, course code, year..." value="{{ request('search') }}"
                           class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                </div>

                <!-- Department Filter -->
                <div class="flex-1 md:max-w-xs">
                    <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Department</label>
                    <select name="department" class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="">-- All Departments --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->name }}" {{ request('department') == $dept->name ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex gap-2 flex-shrink-0">
                    <button type="submit" class="px-5 py-2.5 font-bold text-sm rounded-xl text-white transition" style="background-color: #047857;">
                        Search
                    </button>
                    @if(request()->hasAny(['search', 'department']))
                        <a href="{{ route('past-questions.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200 transition">
                            Clear
                        </a>
                    @endif
                </div>

                <!-- Grid / List Toggle -->
                <div class="flex items-center gap-1 border border-slate-200 rounded-xl p-1 flex-shrink-0">
                    <button type="button" id="gridViewBtn" onclick="setView('grid')" title="Grid View"
                            class="p-2 rounded-lg transition view-toggle-btn active-view">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </button>
                    <button type="button" id="listViewBtn" onclick="setView('list')" title="List View"
                            class="p-2 rounded-lg transition view-toggle-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Results count & sort hint -->
    <div class="flex items-center justify-between mb-5">
        <p class="text-sm text-slate-500">
            Showing <span class="font-bold text-slate-800">{{ $pastQuestions->total() }}</span> result{{ $pastQuestions->total() != 1 ? 's' : '' }}
            @if(request('search') || request('department'))
                for current filter
            @endif
        </p>
    </div>

    <!-- GRID VIEW -->
    <div id="gridView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($pastQuestions as $pq)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-2.5 py-1 rounded-md text-xs font-bold uppercase {{ in_array($pq->file_type, ['jpg','png','jpeg','webp']) ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-indigo-50 text-indigo-700 border border-indigo-200' }}">
                            {{ strtoupper($pq->file_type) }}
                        </span>
                        <div class="flex items-center gap-1.5">
                            @if(!$pq->allow_download)
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-rose-50 text-rose-600 border border-rose-200">Read Only</span>
                            @endif
                            @if($pq->year)
                                <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">{{ $pq->year }}</span>
                            @endif
                        </div>
                    </div>

                    <h3 class="text-base font-bold text-slate-900 mb-3 leading-snug">{{ $pq->title }}</h3>

                    <div class="text-xs text-slate-500 space-y-1 mb-4">
                        @if($pq->department)
                            <p><strong class="text-slate-700">Dept:</strong> {{ $pq->department }}</p>
                        @endif
                        @if($pq->course_code)
                            <p><strong class="text-slate-700">Course:</strong> {{ $pq->course_code }}</p>
                        @endif
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex gap-2">
                    <!-- View Online -->
                    <a href="{{ route('past-questions.view', $pq) }}" target="_blank"
                       class="flex-1 py-2 bg-slate-900 text-white font-bold text-xs rounded-xl hover:bg-slate-700 transition flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        View
                    </a>
                    <!-- Download (conditional) -->
                    @if($pq->allow_download)
                        <a href="{{ route('past-questions.download', $pq) }}"
                           class="flex-1 py-2 text-white font-bold text-xs rounded-xl hover:opacity-90 transition flex items-center justify-center gap-1.5" style="background-color: #047857;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-100">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <h3 class="text-lg font-bold text-slate-800 mb-1">No Past Questions Found</h3>
                <p class="text-slate-500 text-sm">Check back later or adjust your search filters.</p>
            </div>
        @endforelse
    </div>

    <!-- LIST VIEW -->
    <div id="listView" class="hidden flex-col gap-3">
        @forelse($pastQuestions as $pq)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-4 flex-1 min-w-0">
                    <!-- File type icon badge -->
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center font-black text-xs uppercase flex-shrink-0 {{ in_array($pq->file_type, ['jpg','png','jpeg','webp']) ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-indigo-50 text-indigo-700 border border-indigo-200' }}">
                        {{ strtoupper($pq->file_type) }}
                    </div>
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-0.5">
                            <h3 class="font-bold text-slate-900 text-base leading-snug">{{ $pq->title }}</h3>
                            @if(!$pq->allow_download)
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-rose-50 text-rose-600 border border-rose-200">Read Only</span>
                            @endif
                        </div>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-0.5 text-xs text-slate-500">
                            @if($pq->department)
                                <span><strong class="text-slate-700">Dept:</strong> {{ $pq->department }}</span>
                            @endif
                            @if($pq->course_code)
                                <span class="font-semibold text-indigo-600">{{ $pq->course_code }}</span>
                            @endif
                            @if($pq->year)
                                <span class="bg-slate-100 px-2 py-0.5 rounded font-semibold">{{ $pq->year }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('past-questions.view', $pq) }}" target="_blank"
                       class="px-4 py-2 bg-slate-900 text-white font-bold text-xs rounded-xl hover:bg-slate-700 transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        View / Read
                    </a>
                    @if($pq->allow_download)
                        <a href="{{ route('past-questions.download', $pq) }}"
                           class="px-4 py-2 text-white font-bold text-xs rounded-xl hover:opacity-90 transition flex items-center gap-1.5" style="background-color: #047857;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-16 text-center bg-white rounded-2xl border border-slate-100">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <h3 class="text-lg font-bold text-slate-800 mb-1">No Past Questions Found</h3>
                <p class="text-slate-500 text-sm">Check back later or adjust your search filters.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $pastQuestions->links() }}
    </div>
</div>

<style>
.view-toggle-btn {
    color: #94a3b8;
}
.view-toggle-btn:hover {
    background-color: #f1f5f9;
    color: #475569;
}
.view-toggle-btn.active-view {
    background-color: #047857;
    color: #ffffff;
}
</style>

<script>
function setView(mode) {
    const gridView  = document.getElementById('gridView');
    const listView  = document.getElementById('listView');
    const gridBtn   = document.getElementById('gridViewBtn');
    const listBtn   = document.getElementById('listViewBtn');

    if (mode === 'grid') {
        gridView.classList.remove('hidden');
        gridView.classList.add('grid');
        listView.classList.add('hidden');
        listView.classList.remove('flex');
        gridBtn.classList.add('active-view');
        listBtn.classList.remove('active-view');
    } else {
        listView.classList.remove('hidden');
        listView.classList.add('flex');
        gridView.classList.add('hidden');
        gridView.classList.remove('grid');
        listBtn.classList.add('active-view');
        gridBtn.classList.remove('active-view');
    }
    localStorage.setItem('pqViewMode', mode);
}

// Restore last view preference on page load
document.addEventListener('DOMContentLoaded', function () {
    const saved = localStorage.getItem('pqViewMode') || 'grid';
    setView(saved);
});
</script>
@endsection
