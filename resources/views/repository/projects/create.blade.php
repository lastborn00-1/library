<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Upload Project') }}
        </h2>
    </x-slot>

    <div class="py-10" x-data="projectForm()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('repository.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                @csrf

                @if($errors->any())
                    <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-700 text-sm">
                        <p class="font-bold mb-1">Please fix the following errors:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Project Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Title</label>
                            <input type="text" name="title" required value="{{ old('title') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Abstract</label>
                            <textarea name="abstract" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">{{ old('abstract') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Keywords</label>
                            <input type="text" name="keywords" value="{{ old('keywords') }}" placeholder="Comma separated" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Project Type</label>
                            <input type="text" name="project_type" value="{{ old('project_type') }}" placeholder="e.g. Thesis, Final Year Project, Journal" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Author Type (Staff or Student)</label>
                            <select name="author_type" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                                <option value="student" {{ old('author_type') == 'student' ? 'selected' : '' }}>Student Publication</option>
                                <option value="staff" {{ old('author_type') == 'staff' ? 'selected' : '' }}>Staff Publication</option>
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
                            <input type="text" name="department_name" value="{{ old('department_name') }}" placeholder="e.g. Computer Science" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Supervisor Name</label>
                            <input type="text" name="supervisor_name" value="{{ old('supervisor_name') }}" placeholder="e.g. Dr. John Doe" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Academic Session</label>
                            <input type="text" name="academic_session" value="{{ old('academic_session') }}" placeholder="e.g. 2023/2024" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
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
                            <label class="block text-sm font-bold text-slate-700 mb-1">Project PDF *</label>
                            <input type="file" name="pdf_file" accept=".pdf" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm shadow-sm transition file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Status</label>
                            <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Visibility</label>
                            <select name="visibility" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                                <option value="public">Public (OPAC)</option>
                                <option value="internal">Internal (Campus Only)</option>
                                <option value="private">Private (Admin Only)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">Save Project</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function projectForm() {
            return {
                authors: [{ name: '', matric: '' }],
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
