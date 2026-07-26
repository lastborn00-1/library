<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Edit Project') }}
            </h2>
            <a href="{{ route('repository.projects.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition shadow-sm">
                Back to Projects
            </a>
        </div>
    </x-slot>

    <div class="py-10" x-data="projectForm()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('repository.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-8 bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                @csrf
                @method('PUT')

                <!-- Basic Info -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Project Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Title</label>
                            <input type="text" name="title" required value="{{ old('title', $project->title) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Abstract</label>
                            <textarea name="abstract" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">{{ old('abstract', $project->abstract) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Keywords</label>
                            <input type="text" name="keywords" value="{{ old('keywords', $project->keywords) }}" placeholder="Comma separated" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Project Type</label>
                            <input type="text" name="project_type" value="{{ old('project_type', $project->project_type) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Author Type (Staff or Student)</label>
                            <select name="author_type" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                                <option value="student" {{ old('author_type', $project->author_type) == 'student' ? 'selected' : '' }}>Student Publication</option>
                                <option value="staff" {{ old('author_type', $project->author_type) == 'staff' ? 'selected' : '' }}>Staff Publication</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Academic Info -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Academic Context</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Department</label>
                            <input type="text" name="department_name" value="{{ old('department_name', $project->department_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Supervisor Name</label>
                            <input type="text" name="supervisor_name" value="{{ old('supervisor_name', $project->supervisor_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Academic Session</label>
                            <input type="text" name="academic_session" value="{{ old('academic_session', $project->academic_session) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                        </div>
                    </div>
                </div>

                <!-- Authors -->
                <div>
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-bold text-slate-800">Authors</h3>
                        <button type="button" @click="addAuthor" class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-lg hover:bg-indigo-100 transition">Add Author</button>
                    </div>
                    <div class="space-y-4">
                        <template x-for="(author, index) in authors" :key="index">
                            <div class="flex gap-4 items-end bg-slate-50 p-4 rounded-xl border border-slate-200">
                                <div class="flex-grow">
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Author Name *</label>
                                    <input type="text" x-model="author.name" :name="'authors['+index+'][student_name]'" required class="w-full bg-white border border-slate-200 rounded-lg text-sm px-3 py-2">
                                </div>
                                <div class="flex-grow">
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Matric Number / Staff ID</label>
                                    <input type="text" x-model="author.matric" :name="'authors['+index+'][matric_number]'" class="w-full bg-white border border-slate-200 rounded-lg text-sm px-3 py-2">
                                </div>
                                <button type="button" @click="removeAuthor(index)" x-show="authors.length > 1" class="mb-1 p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Files & Settings -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Files & Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Replace PDF (Optional)</label>
                            <input type="file" name="pdf_file" accept=".pdf" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm shadow-sm transition file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @if($project->pdf_path)
                                <p class="text-xs text-emerald-600 mt-2 font-semibold">Current file: {{ basename($project->pdf_path) }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Status</label>
                            <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                                <option value="pending" {{ $project->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $project->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $project->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Visibility</label>
                            <select name="visibility" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                                <option value="public" {{ $project->visibility == 'public' ? 'selected' : '' }}>Public (OPAC)</option>
                                <option value="internal" {{ $project->visibility == 'internal' ? 'selected' : '' }}>Internal (Campus Only)</option>
                                <option value="private" {{ $project->visibility == 'private' ? 'selected' : '' }}>Private (Admin Only)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">Update Project</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function projectForm() {
            return {
                authors: {!! json_encode($project->authors->map(fn($a) => ['name' => $a->student_name, 'matric' => $a->matric_number])) !!},
                addAuthor() {
                    this.authors.push({ name: '', matric: '' });
                },
                removeAuthor(index) {
                    if (this.authors.length > 1) {
                        this.authors.splice(index, 1);
                    }
                }
            }
        }
    </script>
</x-app-layout>
