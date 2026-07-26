<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Manage Past Examination Questions') }}
            </h2>
            <a href="{{ route('settings.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-300 transition">
                &larr; Back to Settings
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Upload Past Question Form -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                <h3 class="text-lg font-bold text-slate-900 mb-6">Upload New Past Question</h3>
                
                <form action="{{ route('settings.past-questions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Title / Exam Name *</label>
                            <input type="text" name="title" required placeholder="e.g. First Semester Exam 2023" value="{{ old('title') }}"
                                   class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('title') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Department (Optional)</label>
                            <select name="department" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">-- Select Department --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->name }}" {{ old('department') == $dept->name ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Course Code (Optional)</label>
                            <input type="text" name="course_code" placeholder="e.g. CHE 101, MLT 202" value="{{ old('course_code') }}"
                                   class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('course_code') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Year / Session (Optional)</label>
                            <input type="text" name="year" placeholder="e.g. 2022/2023" value="{{ old('year') }}"
                                   class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('year') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Past Question File *</label>
                        <input type="file" name="file" required accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,.doc,.docx,.csv,.xlsx,.xls"
                               class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="text-xs text-slate-400 mt-1">Supports PDF, images (JPG, PNG, WebP, GIF), Word documents (DOC, DOCX) and spreadsheets (CSV, XLSX) &mdash; up to 50MB.</p>
                        @error('file') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Permission Toggle -->
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="allow_download" value="1" checked
                                   class="w-5 h-5 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                            <div>
                                <span class="text-sm font-extrabold text-slate-900">Allow Students to Download File</span>
                                <p class="text-xs text-slate-500">Uncheck to make this file <strong>Read Only</strong> — students can view it online but cannot download it.</p>
                            </div>
                        </label>
                    </div>

                    <div>
                        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition">
                            Upload Past Question
                        </button>
                    </div>
                </form>
            </div>

            <!-- Uploaded Past Questions List -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900">Uploaded Past Questions ({{ $pastQuestions->count() }})</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-700 font-semibold uppercase text-xs">
                            <tr>
                                <th class="px-6 py-4">Title</th>
                                <th class="px-6 py-4">Department / Course</th>
                                <th class="px-6 py-4">Year</th>
                                <th class="px-6 py-4">File Type</th>
                                <th class="px-6 py-4">Permission</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($pastQuestions as $pq)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $pq->title }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-800">{{ $pq->department ?? 'General' }}</div>
                                        @if($pq->course_code)
                                            <span class="inline-block bg-slate-100 text-slate-600 px-2 py-0.5 rounded text-xs mt-0.5">{{ $pq->course_code }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $pq->year ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase {{ in_array($pq->file_type, ['jpg','png','jpeg']) ? 'bg-amber-50 text-amber-700' : 'bg-indigo-50 text-indigo-700' }}">
                                            {{ strtoupper($pq->file_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-bold">
                                        @if($pq->allow_download)
                                            <span class="px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200">Downloadable</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-md bg-rose-50 text-rose-700 border border-rose-200">Read Only</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a href="{{ route('past-questions.view', $pq) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 text-slate-700 rounded-lg text-xs font-bold hover:bg-slate-200 transition inline-block">
                                            View
                                        </a>
                                        <a href="{{ route('settings.past-questions.edit', $pq) }}" class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-bold hover:bg-indigo-100 transition inline-block">
                                            Edit
                                        </a>
                                        @if($pq->allow_download)
                                            <a href="{{ route('past-questions.download', $pq) }}" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-bold hover:bg-emerald-100 transition inline-block">
                                                Download
                                            </a>
                                        @endif
                                        <form action="{{ route('settings.past-questions.destroy', $pq) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this past question?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-rose-50 text-rose-600 rounded-lg text-xs font-bold hover:bg-rose-100 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                        No past questions uploaded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
