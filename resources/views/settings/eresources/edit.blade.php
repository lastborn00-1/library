<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('settings.eresources.index') }}" class="text-slate-500 hover:text-slate-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">Edit E-Resource</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-700 text-sm">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('settings.eresources.update', $eresource) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Title <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" required value="{{ old('title', $eresource->title) }}"
                                class="w-full rounded-xl border-slate-200 shadow-sm px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Category <span class="text-rose-500">*</span></label>
                            <input type="text" name="category" required value="{{ old('category', $eresource->category) }}"
                                class="w-full rounded-xl border-slate-200 shadow-sm px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">School <span class="text-slate-400 font-normal">(Optional)</span></label>
                            <input type="text" name="school" placeholder="e.g. School of Dental Technology" value="{{ old('school', $eresource->school) }}"
                                class="w-full rounded-xl border-slate-200 shadow-sm px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Department <span class="text-slate-400 font-normal">(Optional)</span></label>
                            <select name="department" class="w-full rounded-xl border-slate-200 shadow-sm px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                                <option value="">-- Select Department (Optional) --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->name }}" @selected(old('department', $eresource->department) == $dept->name)>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                </div>
                                <span class="font-bold text-slate-700">Option A — External URL</span>
                            </div>
                            <input type="url" name="url" placeholder="https://..." value="{{ old('url', $eresource->url) }}"
                                class="w-full rounded-xl border-slate-200 bg-white shadow-sm px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                            <p class="text-xs text-slate-400 mt-2">Leave blank if replacing with a file upload.</p>
                        </div>

                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-8 h-8 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </div>
                                <span class="font-bold text-slate-700">Option B — Upload File</span>
                            </div>
                            @if($eresource->file_path)
                                <div class="mb-2 text-xs text-slate-500 flex items-center gap-1">
                                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Current: <a href="{{ asset('storage/' . $eresource->file_path) }}" target="_blank" class="text-indigo-500 hover:underline">View File</a>
                                </div>
                            @endif
                            <label class="flex flex-col items-center justify-center w-full h-20 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer bg-white hover:bg-indigo-50 hover:border-indigo-400 transition">
                                <svg class="w-6 h-6 text-slate-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <span class="text-xs text-slate-500">Click to upload new file</span>
                                <input type="file" name="file" class="hidden" accept=".pdf,.doc,.docx,.txt,.xls,.xlsx,.ppt,.pptx">
                            </label>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                        <a href="{{ route('settings.eresources.index') }}" class="px-6 py-3 border border-slate-200 text-slate-600 font-semibold rounded-xl hover:bg-slate-50 transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-sm">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
