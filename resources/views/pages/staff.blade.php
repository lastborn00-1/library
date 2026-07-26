@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data="{ view: 'grid' }">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-12">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900">Library Staff</h1>
            <p class="mt-4 text-xl text-slate-500">Meet the dedicated team managing the Kwara State College of Health Technology Library.</p>
        </div>
        
        <!-- View Toggle -->
        <div class="mt-6 md:mt-0 flex bg-slate-100 p-1 rounded-lg">
            <button @click="view = 'grid'" :class="{ 'bg-white shadow-sm text-indigo-600': view === 'grid', 'text-slate-500 hover:text-slate-700': view !== 'grid' }" class="px-4 py-2 rounded-md text-sm font-semibold flex items-center transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Grid
            </button>
            <button @click="view = 'list'" :class="{ 'bg-white shadow-sm text-indigo-600': view === 'list', 'text-slate-500 hover:text-slate-700': view !== 'list' }" class="px-4 py-2 rounded-md text-sm font-semibold flex items-center transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                List
            </button>
        </div>
    </div>

    @if($staff->isEmpty())
        <div class="text-center py-20 bg-white rounded-2xl border border-slate-100 shadow-sm">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <h3 class="text-xl font-bold text-slate-700">No Staff Members Found</h3>
            <p class="text-slate-500">Staff profiles will appear here once added by the administration.</p>
        </div>
    @else
        <!-- Grid View -->
        <div x-show="view === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($staff as $member)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition">
                    <div class="h-32 bg-indigo-50 relative"></div>
                    <div class="px-6 pb-6 relative text-center">
                        <div class="w-24 h-24 rounded-full border-4 border-white bg-slate-100 mx-auto -mt-12 overflow-hidden shadow-sm relative z-10">
                            @if($member->image_path)
                                <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-100">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <h3 class="mt-4 text-xl font-bold text-slate-900">{{ $member->name }}</h3>
                        <p class="text-indigo-600 font-semibold text-sm">{{ $member->title }}</p>
                        
                        @if($member->email)
                            <div class="mt-3 inline-flex items-center space-x-1 text-slate-500 text-sm bg-slate-50 px-3 py-1 rounded-full">
                                <svg class="w-3 h-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span>{{ $member->email }}</span>
                            </div>
                        @endif

                        @if($member->bio && (str_contains(strtolower($member->title), 'chief librarian') || str_contains(strtolower($member->title), 'college librarian')))
                            <div class="mt-4 text-sm text-indigo-500 font-medium text-left border-t border-slate-50 pt-4">
                                <a href="{{ url('/about') }}" class="hover:underline">Read full biography on the About page &rarr;</a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- List View -->
        <div x-show="view === 'list'" class="space-y-4" style="display: none;">
            @foreach($staff as $member)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <div class="w-24 h-24 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0 shadow-sm border border-slate-100">
                        @if($member->image_path)
                            @php
                                $memberImageUrl = str_starts_with($member->image_path, 'images/') 
                                    ? asset($member->image_path) 
                                    : asset('storage/' . $member->image_path);
                            @endphp
                            <img src="{{ $memberImageUrl }}" alt="{{ $member->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow text-center sm:text-left">
                        <h3 class="text-2xl font-bold text-slate-900">{{ $member->name }}</h3>
                        <p class="text-indigo-600 font-semibold">{{ $member->title }}</p>
                        
                        @if($member->email)
                            <div class="mt-3 flex items-center justify-center sm:justify-start gap-1 text-sm text-slate-500">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $member->email }}
                            </div>
                        @endif

                        @if($member->bio && (str_contains(strtolower($member->title), 'chief librarian') || str_contains(strtolower($member->title), 'college librarian')))
                            <div class="mt-4 text-sm text-indigo-500 font-medium p-4">
                                <a href="{{ url('/about') }}" class="hover:underline">Read full biography on the About page &rarr;</a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
