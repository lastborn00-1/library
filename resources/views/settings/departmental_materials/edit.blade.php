<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                {{ __('Edit Departmental Material') }}
            </h2>
            <a href="{{ route('settings.departmental-materials.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-200 transition">
                &larr; Back to Materials List
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if($errors->any())
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-sm font-bold shadow-sm">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Edit Form -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-900 mb-2">Edit Material Details</h3>
                <p class="text-sm text-slate-500 mb-6">Modify the details, department, or download permissions for <strong>{{ $material->title }}</strong>.</p>

                <form action="{{ route('settings.departmental-materials.update', $material->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="department_id" class="block text-sm font-bold text-slate-700 mb-2">Target Department <span class="text-rose-500">*</span></label>
                            <select id="department_id" name="department_id" required class="w-full rounded-xl border-slate-200 text-slate-900 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id', $material->department_id) == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="course_code" class="block text-sm font-bold text-slate-700 mb-2">Course Code <span class="text-slate-400 font-normal">(optional)</span></label>
                            <input type="text" id="course_code" name="course_code" value="{{ old('course_code', $material->course_code) }}" placeholder="e.g. PHE 201" class="w-full rounded-xl border-slate-200 text-slate-900 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Material Title <span class="text-rose-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $material->title) }}" required class="w-full rounded-xl border-slate-200 text-slate-900 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Description / Notes <span class="text-slate-400 font-normal">(optional)</span></label>
                        <textarea id="description" name="description" rows="3" class="w-full rounded-xl border-slate-200 text-slate-900 text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $material->description) }}</textarea>
                    </div>

                    <!-- Permission Toggle: Downloadable vs Read Only -->
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="allow_download" value="1" {{ old('allow_download', $material->allow_download) ? 'checked' : '' }}
                                   class="w-5 h-5 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                            <div>
                                <span class="text-sm font-extrabold text-slate-900">Allow Students to Download File</span>
                                <p class="text-xs text-slate-500">If unchecked, the file will be set to <strong>Read Only</strong> online mode (no download button will be shown to users).</p>
                            </div>
                        </label>
                    </div>

                    <div>
                        <label for="file" class="block text-sm font-bold text-slate-700 mb-2">Replace File <span class="text-slate-400 font-normal">(leave blank to keep current file)</span></label>
                        <input type="file" id="file" name="file" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                        <p class="text-xs text-slate-400 mt-1">Current file: <span class="font-bold text-slate-700">{{ $material->file_path }}</span> ({{ $material->file_size }})</p>
                    </div>

                    <div class="pt-4 flex items-center gap-4">
                        <button type="submit" style="background-color: #4f46e5; color: #ffffff;" class="px-6 py-3 font-extrabold text-sm rounded-xl hover:bg-indigo-700 transition shadow">
                            Save Changes
                        </button>
                        <a href="{{ route('settings.departmental-materials.index') }}" class="px-6 py-3 bg-slate-100 text-slate-700 font-bold text-sm rounded-xl hover:bg-slate-200 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
