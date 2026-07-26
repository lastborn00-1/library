<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Project Details') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('repository.projects.edit', $project) }}" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition shadow-sm">
                    Edit Project
                </a>
                <a href="{{ route('repository.projects.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition shadow-sm">
                    Back to Projects
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <div class="mb-6 border-b border-slate-100 pb-6">
                    <h1 class="text-3xl font-black text-slate-800 mb-2">{{ $project->title }}</h1>
                    <div class="flex flex-wrap gap-4 text-sm text-slate-500 font-medium">
                        <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> 
                            @foreach($project->authors as $author)
                                {{ $author->student_name }} ({{ $author->matric_number }}){{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </span>
                        <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> {{ $project->created_at->format('F d, Y') }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Abstract</h4>
                        <p class="text-slate-600 text-sm leading-relaxed">{{ $project->abstract ?? 'No abstract provided.' }}</p>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Keywords</h4>
                            <div class="flex flex-wrap gap-2">
                                @if($project->keywords)
                                    @foreach(explode(',', $project->keywords) as $kw)
                                        <span class="px-2 py-1 bg-slate-100 text-slate-600 text-xs font-semibold rounded-lg">{{ trim($kw) }}</span>
                                    @endforeach
                                @else
                                    <span class="text-sm text-slate-500">None</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Department</h4>
                            <p class="text-slate-700 font-medium">{{ $project->department_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Supervisor</h4>
                            <p class="text-slate-700 font-medium">{{ $project->supervisor_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Session</h4>
                            <p class="text-slate-700 font-medium">{{ $project->academic_session ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                @if($project->pdf_path)
                    <div class="border-t border-slate-100 pt-6">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Files</h4>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('repository.projects.download', $project) }}" class="px-6 py-2.5 bg-slate-800 text-white font-bold rounded-xl hover:bg-slate-900 transition flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download PDF
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
