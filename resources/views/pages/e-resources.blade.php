@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
        <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <h1 class="text-3xl font-extrabold text-slate-900 mb-4">Electronic Resources to Support Teaching, Learning, and Research</h1>
        <div class="prose prose-indigo max-w-none text-slate-600 mb-12 bg-white p-8 rounded-2xl shadow-sm border border-slate-100 text-left">
            <p class="mb-4">
                As part of its continued commitment to strengthening teaching, learning, and research, the Kwara State College of Health Technology, Offa (COHETCH Offa), has secured institutional subscriptions to a range of reputable electronic information resources and scholarly databases for the benefit of staff and students.
            </p>
            <p class="mb-4">
                The College Library has made available the requisite access details for these resources, including the respective website addresses, usernames, and passwords, for the exclusive use of authorized members of the College community.
            </p>
            <h3 class="text-xl font-bold text-slate-800 mt-6 mb-2">Confidentiality Notice</h3>
            <p class="mb-4">
                In accordance with the licensing agreements governing these subscriptions, all authorized users are required to maintain the strict confidentiality of the access credentials. The disclosure, sharing, or unauthorized use of these credentials may constitute a breach of the licensing terms and could jeopardize the College's continued access to these valuable electronic resources.
            </p>
            <p class="mb-4">
                Members of the College community who experience any difficulty in accessing the subscribed databases are advised to contact the E-Librarian promptly for the necessary assistance.
            </p>
            <p>
                Furthermore, the College Library welcomes recommendations from staff and students regarding reputable scholarly databases and other electronic information resources of academic value that are not presently included in the College's subscription portfolio. Such recommendations will be given due consideration as part of the Library's ongoing commitment to strengthening its electronic collections and supporting excellence in teaching, learning, research, and innovation.
            </p>
        </div>

        @if(isset($resources) && $resources->count() > 0)
            
            @php
                $generalResources = $resources->whereNull('school');
                $schoolResources = $resources->whereNotNull('school');
            @endphp

            {{-- 1. General Databases (Grouped by Category) --}}
            @if($generalResources->count() > 0)
                @php $generalGrouped = $generalResources->groupBy('category'); @endphp
                <div class="text-left mb-16">
                    @foreach($generalGrouped as $category => $links)
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold text-indigo-900 mb-6 border-b border-indigo-100 pb-2">{{ $category }}</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($links as $link)
                                    @php $href = $link->url ?? ($link->file_path ? asset('storage/' . $link->file_path) : '#'); @endphp
                                    <a href="{{ $href }}" target="_blank" rel="noopener noreferrer" class="block bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-indigo-200 transition group flex items-start text-left">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mr-4 flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-slate-800 group-hover:text-indigo-600 transition">{{ $link->title }}</h3>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- 2. Discipline Specific Databases (Grouped by School, then Department) --}}
            @if($schoolResources->count() > 0)
                <div class="text-left">
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-8 border-b-2 border-slate-200 pb-4">Discipline Specific Online Databases</h2>
                    
                    @php $schoolsGrouped = $schoolResources->groupBy('school'); @endphp
                    @foreach($schoolsGrouped as $schoolName => $schoolLinks)
                        <div class="mb-12">
                            <h3 class="text-2xl font-bold text-indigo-800 mb-6">{{ $schoolName }}</h3>
                            
                            @php 
                                // Group further by department. Use 'General' if department is null.
                                $deptGrouped = $schoolLinks->groupBy(function($item) {
                                    return $item->department ?: 'General Resources';
                                });
                            @endphp

                            @foreach($deptGrouped as $deptName => $deptLinks)
                                <div class="mb-8 ml-0 lg:ml-6">
                                    @if($deptName !== 'General Resources')
                                        <h4 class="text-xl font-bold text-slate-700 mb-4 border-b border-slate-100 pb-2">{{ $deptName }}</h4>
                                    @endif
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        @foreach($deptLinks as $link)
                                            @php $href = $link->url ?? ($link->file_path ? asset('storage/' . $link->file_path) : '#'); @endphp
                                            <a href="{{ $href }}" target="_blank" rel="noopener noreferrer" class="block bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-indigo-200 transition group flex items-start text-left">
                                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mr-4 flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-slate-800 group-hover:text-indigo-600 transition">{{ $link->title }}</h3>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif

        @else
            <div class="text-center py-12 text-slate-400">
                <p>No e-resources have been added yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
