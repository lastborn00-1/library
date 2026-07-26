@extends('layouts.public')

@section('title', 'Institutional Repository - KWCHT')

@section('content')
<div class="bg-slate-50 py-12 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-4">KWCHT Institutional Repository</h1>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto mb-8">
            Browse and discover open access research, journals, and articles published by the Kwara State College of Health Technology community.
        </p>

        <!-- Search Bar -->
        <div class="max-w-3xl mx-auto">
            <form action="{{ route('repository.search') }}" method="GET" class="flex gap-2">
                <input type="text" name="q" placeholder="Search the repository..." class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent shadow-sm">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-sm hover:bg-indigo-700 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Search
                </button>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4 border-b pb-2">Browse by Type</h3>
                <ul class="space-y-3">
                    @forelse($typeCounts as $type => $count)
                        <li>
                            <a href="{{ route('repository.search', ['q' => $type]) }}" class="flex justify-between items-center text-slate-600 hover:text-indigo-600 transition">
                                <span class="capitalize">{{ $type ?: 'Other' }}</span>
                                <span class="bg-indigo-50 text-indigo-700 py-0.5 px-2.5 rounded-full text-xs font-semibold">{{ $count }}</span>
                            </a>
                        </li>
                    @empty
                        <li class="text-slate-500 text-sm">No categories available yet.</li>
                    @endforelse
                </ul>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4 border-b pb-2">Information</h3>
                <p class="text-sm text-slate-600 mb-4">
                    Some items in our repository (such as student projects) are restricted to internal college members. Please log in to view restricted items.
                </p>
                @guest
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 bg-slate-900 text-white font-semibold rounded-lg hover:bg-slate-800 transition">Log In</a>
                @endguest
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3">
            @php
                $headingTitle = 'Recent Additions';
                if ($type === 'staff') {
                    $headingTitle = 'Staff Publications';
                } elseif ($type === 'student') {
                    $headingTitle = 'Student Publications';
                }
            @endphp
            <h2 class="text-2xl font-bold text-slate-900 mb-6">{{ $headingTitle }}</h2>
            
            @if($recentItems->count() > 0)
                <div class="space-y-4">
                    @foreach($recentItems as $item)
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition">
                            <div class="flex justify-between items-start gap-4">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900 mb-1">
                                        <a href="{{ route('repository.projects.show_public', $item) }}" class="hover:text-indigo-600 transition">
                                            {{ $item->title }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-slate-500 mb-3">
                                        @foreach($item->authors as $author)
                                            {{ $author->student_name }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                        <span class="mx-2">•</span>
                                        {{ $item->created_at->format('M Y') }}
                                    </p>
                                    @if($item->abstract)
                                        <p class="text-slate-600 text-sm line-clamp-2 mb-4">{{ $item->abstract }}</p>
                                    @endif
                                </div>
                                @if($item->project_type)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 capitalize shrink-0">
                                        {{ $item->project_type }}
                                    </span>
                                @endif
                            </div>
                            <div class="mt-2 flex gap-3">
                                <a href="{{ route('repository.projects.show_public', $item) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">View Details &rarr;</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-xl border border-slate-200">
                    <svg class="mx-auto h-12 w-12 text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <h3 class="text-lg font-medium text-slate-900 mb-1">No Public Items Yet</h3>
                    <p class="text-slate-500">Public journals and articles will appear here once they are added by administrators.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
