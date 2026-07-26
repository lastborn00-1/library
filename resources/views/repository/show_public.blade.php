@extends('layouts.public')

@section('title', $project->title . ' - Repository - KWCHT')

@section('content')
<div class="bg-slate-50 py-12 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('repository.home') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 mb-6 transition">
            <svg class="mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Repository Home
        </a>
        
        <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">{{ $project->title }}</h1>
        
        <div class="flex flex-wrap gap-4 text-sm text-slate-600 mb-4">
            <div class="flex items-center">
                <svg class="mr-1.5 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                @foreach($project->authors as $author)
                    {{ $author->student_name }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </div>
            @if($project->project_type)
                <div class="flex items-center">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-200 text-slate-800 capitalize">
                        {{ $project->project_type }}
                    </span>
                </div>
            @endif
            @if($project->department_name)
                <div class="flex items-center">
                    <svg class="mr-1.5 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    {{ $project->department_name }}
                </div>
            @endif
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Abstract -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sm:p-8">
                <h3 class="text-xl font-bold text-slate-900 mb-4 border-b pb-4">Abstract</h3>
                <div class="prose max-w-none text-slate-600 leading-relaxed">
                    @if($project->abstract)
                        {!! nl2br(e($project->abstract)) !!}
                    @else
                        <p class="italic text-slate-500">No abstract available for this item.</p>
                    @endif
                </div>
            </div>

            <!-- Details -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sm:p-8">
                <h3 class="text-xl font-bold text-slate-900 mb-4 border-b pb-4">Details</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                    @if($project->keywords)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-slate-500">Keywords</dt>
                        <dd class="mt-1 text-sm text-slate-900">
                            @foreach(explode(',', $project->keywords) as $keyword)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800 mr-2 mb-2">{{ trim($keyword) }}</span>
                            @endforeach
                        </dd>
                    </div>
                    @endif
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Date Added</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $project->created_at->format('F d, Y') }}</dd>
                    </div>
                    @if($project->academic_session)
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Academic Session</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $project->academic_session }}</dd>
                    </div>
                    @endif
                    @if($project->supervisor_name)
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Supervisor</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $project->supervisor_name }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Sidebar / View Button -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sticky top-28">
                <h3 class="text-lg font-bold text-slate-900 mb-4 text-center">View Document</h3>
                
                @if($project->visibility === 'public' || auth()->check())
                    <a href="{{ route('repository.projects.view', $project) }}" target="_blank" class="flex items-center justify-center w-full px-4 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition shadow-sm mb-3">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        View Full Text (PDF)
                    </a>
                    <p class="text-xs text-center text-slate-500">Document opens in a new tab.</p>
                @else
                    <div class="text-center p-4 bg-orange-50 border border-orange-100 rounded-lg mb-4">
                        <svg class="mx-auto h-8 w-8 text-orange-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <p class="text-sm text-orange-800 font-medium mb-1">Restricted Access</p>
                        <p class="text-xs text-orange-600">This document is restricted to institutional members.</p>
                    </div>
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 bg-slate-900 text-white font-semibold rounded-lg hover:bg-slate-800 transition">
                        Log In to View
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
