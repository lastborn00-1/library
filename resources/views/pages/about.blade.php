@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    {{-- Page Header --}}
    <div class="bg-indigo-600 rounded-2xl px-8 py-12 text-center mb-10">
        <h1 class="text-3xl font-extrabold text-white mb-2">About the Library</h1>
        <p class="text-indigo-100 max-w-2xl mx-auto">Kwara State College of Health Technology, Offa</p>
    </div>

    {{-- About Library Text (ALWAYS AT TOP) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 md:p-12 text-slate-600 leading-relaxed space-y-6 text-lg mb-10">
        <p>
            Welcome to the College Library of Kwara State College of Health Technology, Offa. Our library is the academic heart of the institution, dedicated to supporting the teaching, learning, and research needs of our students and faculty in the health sciences.
        </p>
        <p>
            We provide access to a wide variety of both physical and digital resources, spanning all departments including Community Health, Environmental Health, Health Information Management, Medical Laboratory Science, Pharmacy Technician, and more.
        </p>
        <p>
            <strong>Our Mission</strong> is to provide comprehensive resources and services in support of the research, teaching, and learning needs of the College community.
        </p>
        <p>
            <strong>Our Vision</strong> is to be a modern, world-class center of academic excellence where health information is easily accessible in a conducive environment.
        </p>
    </div>

    {{-- Librarian Profile (Photo on top, details below) --}}
    @if(isset($chiefLibrarian))
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden p-8 md:p-12">
        <div class="flex flex-col items-center text-center">
            {{-- Photo Panel (Top) --}}
            <div class="mb-6">
                @if($chiefLibrarian->image_path)
                    @php
                        $imageUrl = str_starts_with($chiefLibrarian->image_path, 'images/')
                            ? asset($chiefLibrarian->image_path)
                            : asset('storage/' . $chiefLibrarian->image_path);
                    @endphp
                    <img src="{{ $imageUrl }}"
                         alt="{{ $chiefLibrarian->name }}"
                         class="w-48 h-56 object-cover object-top rounded-2xl shadow-xl border-4 border-white ring-1 ring-slate-200">
                @else
                    <div class="w-48 h-56 bg-slate-200 rounded-2xl flex items-center justify-center text-slate-400 shadow-inner">
                        <svg class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Title Badge --}}
            <div class="inline-block px-3.5 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-widest rounded-full mb-3">
                {{ $chiefLibrarian->title }}
            </div>

            {{-- Name --}}
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-2">
                {{ $chiefLibrarian->name }}
            </h2>

            {{-- Qualifications --}}
            @if($chiefLibrarian->qualifications)
                <p class="text-slate-500 font-medium italic mb-4 max-w-2xl">
                    {{ $chiefLibrarian->qualifications }}
                </p>
            @endif

            {{-- Contact info if available --}}
            @if($chiefLibrarian->phone)
                <div class="flex items-center gap-2 text-slate-500 text-sm font-medium mb-6">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <span>{{ $chiefLibrarian->phone }}</span>
                </div>
            @endif

            {{-- Accent Divider --}}
            <div class="w-16 h-1 bg-emerald-500 rounded-full mb-8"></div>

            {{-- Bio Details --}}
            <div class="prose prose-slate text-slate-600 max-w-4xl text-left leading-relaxed text-base md:text-lg">
                @if($chiefLibrarian->bio)
                    {!! nl2br(e($chiefLibrarian->bio)) !!}
                @else
                    <p class="text-center text-slate-400">Biography details are currently being updated.</p>
                @endif
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
