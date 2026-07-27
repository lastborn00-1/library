@extends('layouts.public')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Title matching Al-Hikmah style -->
        <div class="mb-8 border-b border-slate-200 pb-4">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <span class="text-emerald-600">eLibrary</span> Resources
            </h1>
        </div>

        <!-- Grey Quote Block Banner matching screenshot -->
        <div class="bg-slate-200 rounded-xl p-6 mb-10 shadow-sm border border-slate-300 flex items-start gap-4">
            <div class="text-4xl text-slate-500 font-serif leading-none select-none">
                &#8221;&#8221;
            </div>
            <div>
                <p class="text-slate-700 text-sm md:text-base font-semibold leading-relaxed">
                    Welcome to the KWCHT Departmental eLibrary Resources. Select your academic department below to access and download official lecture notes, e-books, course materials, and study resources.
                </p>
            </div>
        </div>

        <!-- Subheading Section -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-2xl font-black text-slate-900 flex items-center gap-2">
                <span class="text-emerald-600 text-2xl font-bold">+</span> KWCHT eLibrary Resources
            </h2>
            <div class="text-xs font-bold text-slate-500 bg-white border border-slate-200 px-4 py-2 rounded-lg shadow-sm">
                Total Departments: <span class="text-emerald-600 font-extrabold text-sm">{{ $departments->count() }}</span>
            </div>
        </div>

        <!-- Department Access Link Table (Matching Al-Hikmah Screenshot layout) -->
        <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr style="background-color: #047857; color: #ffffff;" class="text-xs uppercase font-extrabold tracking-wider border-b border-emerald-800">
                            <th class="py-3.5 px-6 border-r border-slate-400/30 text-center w-16">SN</th>
                            <th class="py-3.5 px-6 border-r border-slate-400/30">DEPARTMENT</th>
                            <th class="py-3.5 px-6 text-center w-48">ACCESS LINK</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-sm font-medium">
                        @forelse($departments as $index => $dept)
                            <tr class="hover:bg-amber-50/60 transition duration-150 group">
                                <td class="py-4 px-6 text-center text-slate-500 font-bold border-r border-slate-200 group-hover:text-slate-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-4 px-6 text-slate-900 font-bold uppercase tracking-wide border-r border-slate-200">
                                    <div class="flex items-center justify-between">
                                        <span>{{ $dept->name }}</span>
                                        @if($dept->materials_count > 0)
                                            <span class="text-[11px] font-extrabold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 normal-case">
                                                {{ $dept->materials_count }} {{ Str::plural('material', $dept->materials_count) }}
                                            </span>
                                        @else
                                            <span class="text-[11px] font-semibold text-slate-400 normal-case">
                                                No files uploaded yet
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('departmental-materials.show', $dept->id) }}" 
                                       style="color: #ea580c; font-weight: 800;" 
                                       class="inline-flex items-center gap-1.5 hover:underline hover:text-orange-700 transition">
                                        Click Here
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center text-slate-400">
                                    No active departments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 text-center text-xs text-slate-400">
            Kwara State College of Health Technology &bull; Departmental E-Learning & Resource Repository
        </div>
    </div>
</div>
@endsection
