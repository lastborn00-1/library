<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                {{ __('Manage Departmental E-Resources') }}
            </h2>
            <a href="{{ route('settings.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-200 transition">
                &larr; Back to Settings
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-bold shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-sm font-bold shadow-sm">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Upload New Material Form -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-900 mb-2">Upload Departmental Material</h3>
                <p class="text-sm text-slate-500 mb-6">Select a department and upload study materials, lecture notes, or e-books for students.</p>

                <form action="{{ route('settings.departmental-materials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="department_id" class="block text-sm font-bold text-slate-700 mb-2">Target Department <span class="text-rose-500">*</span></label>
                            <select id="department_id" name="department_id" required class="w-full rounded-xl border-slate-200 text-slate-900 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select Department --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="course_code" class="block text-sm font-bold text-slate-700 mb-2">Course Code <span class="text-slate-400 font-normal">(optional)</span></label>
                            <input type="text" id="course_code" name="course_code" value="{{ old('course_code') }}" placeholder="e.g. PHE 201" class="w-full rounded-xl border-slate-200 text-slate-900 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Material Title <span class="text-rose-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. Environmental Health Lecture Manual" class="w-full rounded-xl border-slate-200 text-slate-900 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Description / Notes <span class="text-slate-400 font-normal">(optional)</span></label>
                        <textarea id="description" name="description" rows="2" placeholder="Brief description of the material..." class="w-full rounded-xl border-slate-200 text-slate-900 text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                    </div>

                    <!-- Permission Toggle: Downloadable vs Read Only -->
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="allow_download" value="1" checked
                                   class="w-5 h-5 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                            <div>
                                <span class="text-sm font-extrabold text-slate-900">Allow Students to Download File</span>
                                <p class="text-xs text-slate-500">Uncheck this if you want the material to be <strong>Read Only</strong> online mode (hides download button for students).</p>
                            </div>
                        </label>
                    </div>

                    <div>
                        <label for="file" class="block text-sm font-bold text-slate-700 mb-2">Select File <span class="text-rose-500">*</span></label>
                        <input type="file" id="file" name="file" required accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,.doc,.docx,.csv,.xlsx,.xls"
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                        <p class="text-xs text-slate-400 mt-1">Supports PDF, images (JPG, PNG, WebP, GIF), Word (DOC, DOCX) and spreadsheets (CSV, XLSX) — Max 50MB.</p>
                    </div>

                    <div class="pt-2">
                        <button type="submit" style="background-color: #4f46e5; color: #ffffff;" class="px-6 py-3 font-extrabold text-sm rounded-xl hover:bg-indigo-700 transition shadow">
                            Upload Material
                        </button>
                    </div>
                </form>
            </div>

            <!-- Existing Materials Table -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <h3 class="text-lg font-bold text-slate-900">Uploaded Departmental Materials</h3>
                    
                    <form method="GET" action="{{ route('settings.departmental-materials.index') }}" class="flex items-center gap-2">
                        <select name="department_id" onchange="this.form.submit()" class="rounded-xl border-slate-200 text-xs font-semibold text-slate-700">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ $selectedDepartmentId == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-xs uppercase font-extrabold text-slate-500 border-b border-slate-100">
                                <th class="py-3.5 px-6">Department</th>
                                <th class="py-3.5 px-6">Title / Course</th>
                                <th class="py-3.5 px-6">Type & Size</th>
                                <th class="py-3.5 px-6">Permission</th>
                                <th class="py-3.5 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($materials as $material)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="py-4 px-6 font-bold text-slate-900">
                                        {{ $material->department->name ?? 'N/A' }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-slate-800">{{ $material->title }}</div>
                                        @if($material->course_code)
                                            <div class="text-xs font-semibold text-indigo-600">{{ $material->course_code }}</div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-xs text-slate-500">
                                        <span class="uppercase font-extrabold px-2 py-0.5 rounded bg-slate-100 text-slate-700">{{ $material->file_type }}</span>
                                        <span class="ml-1">{{ $material->file_size }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-xs font-bold">
                                        @if($material->allow_download)
                                            <span class="px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Downloadable
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-md bg-rose-50 text-rose-700 border border-rose-200">
                                                Read Only
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <a href="{{ route('departmental-materials.view', $material->id) }}" target="_blank" class="text-xs font-bold text-slate-700 hover:text-slate-900 hover:underline">
                                            View
                                        </a>
                                        <a href="{{ route('settings.departmental-materials.edit', $material->id) }}" class="text-xs font-bold text-indigo-600 hover:underline">
                                            Edit
                                        </a>
                                        @if($material->allow_download)
                                            <a href="{{ route('departmental-materials.download', $material->id) }}" class="text-xs font-bold text-amber-600 hover:underline">
                                                Download
                                            </a>
                                        @endif
                                        <form action="{{ route('settings.departmental-materials.destroy', $material->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this material?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-bold text-rose-600 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400">
                                        No materials found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($materials->hasPages())
                    <div class="p-6 border-t border-slate-100">
                        {{ $materials->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
