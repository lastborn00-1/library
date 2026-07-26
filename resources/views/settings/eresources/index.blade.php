<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Manage E-Resources') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-700 text-sm font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-700 text-sm font-semibold">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Info Card --}}
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-8 flex items-start gap-4">
                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-amber-800 mb-1">E-Resources Management</h3>
                    <p class="text-amber-700 text-sm leading-relaxed">
                        Add external database links <strong>or</strong> upload full-text files (PDF, Word, etc.) that will appear on the public E-Resources page. You can add both a URL and a file for any resource.
                    </p>
                </div>
            </div>

            {{-- Add New E-Resource Form --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-8">
                <h3 class="text-xl font-bold text-slate-800 mb-1">Add New E-Resource</h3>
                <p class="text-slate-400 text-sm mb-6">Fill in a URL <em>or</em> upload a file — or both.</p>

                <form action="{{ route('settings.eresources.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Row 1: Title + Category --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Title <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" required placeholder="e.g. Science Direct Open Access"
                                   class="w-full rounded-xl border border-slate-200 shadow-sm px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
                                   value="{{ old('title') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Category <span class="text-rose-500">*</span></label>
                            <input type="text" name="category" value="{{ old('category', 'Multi-Discipline Databases') }}" required
                                   class="w-full rounded-xl border border-slate-200 shadow-sm px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                        </div>
                    </div>

                    {{-- Row 2: School + Department (Optional Hierarchy) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">School <span class="text-slate-400 font-normal">(Optional)</span></label>
                            <input type="text" name="school" placeholder="e.g. School of Dental Technology"
                                   class="w-full rounded-xl border border-slate-200 shadow-sm px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
                                   value="{{ old('school') }}">
                            <p class="text-xs text-slate-400 mt-1">Leave blank for general databases.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Department <span class="text-slate-400 font-normal">(Optional)</span></label>
                            <select name="department" class="w-full rounded-xl border border-slate-200 shadow-sm px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                                <option value="">-- Select Department (Optional) --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->name }}" @selected(old('department') == $dept->name)>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-400 mt-1">Leave blank if this belongs to the entire school.</p>
                        </div>
                    </div>

                    {{-- Row 3: URL + File Upload side by side --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        {{-- URL Option --}}
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                </div>
                                <span class="font-bold text-slate-700">Option A — External URL / Link</span>
                            </div>
                            <input type="url" name="url" placeholder="https://www.sciencedirect.com/..."
                                   class="w-full rounded-xl border border-slate-200 bg-white shadow-sm px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
                                   value="{{ old('url') }}">
                            <p class="text-xs text-slate-400 mt-2">Leave blank if uploading a file instead.</p>
                        </div>

                        {{-- File Upload Option --}}
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-8 h-8 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </div>
                                <span class="font-bold text-slate-700">Option B — Upload File</span>
                            </div>
                            <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer bg-white hover:bg-indigo-50 hover:border-indigo-400 transition">
                                <svg class="w-7 h-7 text-slate-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <span class="text-xs text-slate-500">Click to upload PDF, DOC, DOCX, XLS, PPT...</span>
                                <span class="text-xs text-slate-400 mt-0.5">Max 20MB</span>
                                <input type="file" name="file" class="hidden" accept=".pdf,.doc,.docx,.txt,.xls,.xlsx,.ppt,.pptx">
                            </label>
                            <p class="text-xs text-slate-400 mt-2">Leave blank if using a URL link instead.</p>
                        </div>
                    </div>

                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 active:bg-indigo-800 transition shadow-sm">
                        ＋ Add E-Resource
                    </button>
                </form>
            </div>

            {{-- Current E-Resources List --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden p-8">
                <h3 class="text-xl font-bold text-slate-800 mb-6">Current E-Resources
                    <span class="ml-2 text-sm font-normal text-slate-400">({{ $resources->count() }} total)</span>
                </h3>
                
                @if($resources->isEmpty())
                    <div class="text-center py-16 text-slate-500 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        <p class="font-medium">No resources added yet.</p>
                        <p class="text-sm text-slate-400 mt-1">Use the form above to add your first E-Resource.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 text-sm border-b border-slate-100">
                                    <th class="py-3 px-4 font-semibold">#</th>
                                    <th class="py-3 px-4 font-semibold">Title</th>
                                    <th class="py-3 px-4 font-semibold">Link / File</th>
                                    <th class="py-3 px-4 font-semibold">Type</th>
                                    <th class="py-3 px-4 font-semibold">Category</th>
                                    <th class="py-3 px-4 font-semibold text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($resources as $i => $res)
                                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition">
                                        <td class="py-4 px-4 text-slate-400 text-sm">{{ $i + 1 }}</td>
                                        <td class="py-4 px-4 text-slate-900 font-medium">{{ $res->title }}</td>
                                        <td class="py-4 px-4 text-sm max-w-xs">
                                            @if($res->file_path)
                                                <a href="{{ asset('storage/' . $res->file_path) }}" target="_blank" class="text-rose-600 hover:underline flex items-center gap-1">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                                                    View File
                                                </a>
                                            @elseif($res->url)
                                                <a href="{{ $res->url }}" target="_blank" class="text-indigo-600 hover:underline truncate block">{{ $res->url }}</a>
                                            @else
                                                <span class="text-slate-400 italic">No link/file</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 text-sm">
                                            @php
                                                $type = strtolower($res->file_type ?? 'link');
                                                $badge = match($type) {
                                                    'pdf'  => 'bg-rose-100 text-rose-700',
                                                    'doc', 'docx' => 'bg-blue-100 text-blue-700',
                                                    'xls', 'xlsx' => 'bg-emerald-100 text-emerald-700',
                                                    'ppt', 'pptx' => 'bg-orange-100 text-orange-700',
                                                    default => 'bg-indigo-100 text-indigo-700',
                                                };
                                            @endphp
                                            <span class="px-2 py-1 rounded-lg text-xs font-bold uppercase {{ $badge }}">{{ strtoupper($type) }}</span>
                                        </td>
                                        <td class="py-4 px-4 text-slate-500 text-sm">
                                            <span class="px-2 py-1 bg-slate-100 rounded text-xs block mb-1 w-max">{{ $res->category }}</span>
                                            @if($res->school)
                                                <span class="text-xs text-slate-400 block">{{ $res->school }}</span>
                                            @endif
                                            @if($res->department)
                                                <span class="text-xs text-slate-400 block">{{ $res->department }}</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <a href="{{ route('settings.eresources.edit', $res) }}" class="text-indigo-500 hover:text-indigo-700 font-semibold text-sm">Edit</a>
                                                <form action="{{ route('settings.eresources.destroy', $res) }}" method="POST" onsubmit="return confirm('Delete this resource?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold text-sm">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
