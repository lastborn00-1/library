<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                {{ __('Edit Past Question') }}
            </h2>
            <a href="{{ route('settings.past-questions.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-200 transition">
                &larr; Back to List
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

            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-900 mb-2">Edit Past Question Details</h3>
                <p class="text-sm text-slate-500 mb-6">Update the information for <strong>{{ $pastQuestion->title }}</strong>.</p>

                <form action="{{ route('settings.past-questions.update', $pastQuestion->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Title / Exam Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" required value="{{ old('title', $pastQuestion->title) }}"
                                   placeholder="e.g. First Semester Exam 2023"
                                   class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Department <span class="text-slate-400 font-normal">(optional)</span></label>
                            <select name="department" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">-- No Department --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->name }}" {{ old('department', $pastQuestion->department) == $dept->name ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Course Code <span class="text-slate-400 font-normal">(optional)</span></label>
                            <input type="text" name="course_code" value="{{ old('course_code', $pastQuestion->course_code) }}"
                                   placeholder="e.g. CHE 101, MLT 202"
                                   class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Year / Session <span class="text-slate-400 font-normal">(optional)</span></label>
                            <input type="text" name="year" value="{{ old('year', $pastQuestion->year) }}"
                                   placeholder="e.g. 2022/2023"
                                   class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                    </div>

                    <!-- Permission Toggle -->
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="allow_download" value="1"
                                   {{ old('allow_download', $pastQuestion->allow_download) ? 'checked' : '' }}
                                   class="w-5 h-5 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                            <div>
                                <span class="text-sm font-extrabold text-slate-900">Allow Students to Download File</span>
                                <p class="text-xs text-slate-500">Uncheck to make this file <strong>Read Only</strong> — students can view online but cannot download it.</p>
                            </div>
                        </label>
                    </div>

                    <!-- Replace File -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Replace File <span class="text-slate-400 font-normal">(leave blank to keep current)</span></label>
                        <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,.doc,.docx,.csv,.xlsx,.xls"
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                        <p class="text-xs text-slate-400 mt-1">
                            Current file: <span class="font-bold text-slate-700">{{ basename($pastQuestion->file_path) }}</span>
                            &bull; Type: <span class="font-bold text-indigo-600 uppercase">{{ $pastQuestion->file_type }}</span>
                        </p>
                    </div>

                    <div class="pt-4 flex items-center gap-4">
                        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-extrabold text-sm rounded-xl hover:bg-indigo-700 transition shadow">
                            Save Changes
                        </button>
                        <a href="{{ route('settings.past-questions.index') }}" class="px-6 py-3 bg-slate-100 text-slate-700 font-bold text-sm rounded-xl hover:bg-slate-200 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
