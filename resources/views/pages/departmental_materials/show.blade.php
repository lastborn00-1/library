@extends('layouts.public')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Navigation -->
        <div class="mb-6">
            <a href="{{ route('departmental-materials.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-100 transition shadow-sm">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to All Departments
            </a>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <span class="text-xs font-black uppercase tracking-wider text-emerald-600 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full">
                    Departmental E-Resources
                </span>
                <h1 class="text-3xl font-black text-slate-900 mt-3 tracking-tight uppercase">
                    {{ $department->name }}
                </h1>
                <p class="text-slate-500 text-sm mt-1">
                    Browse and download official lecture notes, past questions, and academic resources for {{ $department->name }}.
                </p>
            </div>

            <div class="bg-slate-50 border border-slate-200 px-6 py-4 rounded-2xl text-center flex-shrink-0">
                <div class="text-2xl font-black text-slate-900">{{ $materials->count() }}</div>
                <div class="text-xs font-bold text-slate-500 uppercase tracking-wide">Available Files</div>
            </div>
        </div>

        <!-- Material Files List -->
        <div class="space-y-4">
            @forelse($materials as $material)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-md transition flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center font-black uppercase text-xs flex-shrink-0">
                            {{ $material->file_type }}
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <h3 class="text-lg font-bold text-slate-900">{{ $material->title }}</h3>
                                @if($material->course_code)
                                    <span class="px-2.5 py-0.5 rounded-md bg-indigo-50 text-indigo-700 font-extrabold text-xs border border-indigo-200">
                                        {{ $material->course_code }}
                                    </span>
                                @endif
                                @if(!$material->allow_download)
                                    <span class="px-2.5 py-0.5 rounded-md bg-rose-50 text-rose-700 font-extrabold text-[11px] border border-rose-200">
                                        Read Only
                                    </span>
                                @endif
                            </div>
                            @if($material->description)
                                <p class="text-slate-600 text-sm leading-relaxed mb-2">{{ $material->description }}</p>
                            @endif
                            <div class="flex items-center gap-4 text-xs font-semibold text-slate-400">
                                <span>Size: {{ $material->file_size ?: 'N/A' }}</span>
                                @if($material->allow_download)
                                    <span>&bull;</span>
                                    <span>Downloads: {{ number_format($material->downloads_count) }}</span>
                                @endif
                                <span>&bull;</span>
                                <span>Uploaded: {{ $material->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 flex-shrink-0">
                        <!-- Read / View Online Button -->
                        <a href="{{ route('departmental-materials.view', $material->id) }}" target="_blank"
                           class="px-5 py-2.5 font-bold text-xs rounded-xl bg-slate-900 text-white hover:bg-slate-800 transition shadow flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            View / Read Online
                        </a>

                        <!-- Download File Button or Read Only Badge -->
                        @if($material->allow_download)
                            <a href="{{ route('departmental-materials.download', $material->id) }}" 
                               style="background-color: #ea580c; color: #ffffff;" 
                               class="px-5 py-2.5 font-extrabold text-xs rounded-xl hover:bg-orange-700 transition shadow flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 text-slate-400">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-30 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <h3 class="text-lg font-bold text-slate-700 mb-1">No Materials Uploaded Yet</h3>
                    <p class="text-sm text-slate-500">Materials for {{ $department->name }} will be available here once uploaded by the administration.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
