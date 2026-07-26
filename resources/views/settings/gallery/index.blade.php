<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Manage Gallery') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Upload Form -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden p-8 mb-8">
                <h3 class="text-xl font-bold text-slate-800 mb-4">Upload New Image</h3>
                <form action="{{ route('settings.gallery.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row items-end gap-4">
                    @csrf
                    <div class="flex-grow w-full">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Select Image</label>
                        <input type="file" name="image" accept="image/*" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                    </div>
                    <div class="flex-grow w-full">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Caption (Optional)</label>
                        <input type="text" name="caption" placeholder="A brief description..." class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition">Upload</button>
                    </div>
                </form>
                @error('image') <span class="text-rose-500 text-xs mt-2 block">{{ $message }}</span> @enderror
            </div>

            <!-- Existing Images -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden p-8">
                <h3 class="text-xl font-bold text-slate-800 mb-6">Gallery Images</h3>
                
                @if($images->isEmpty())
                    <div class="text-center py-12 text-slate-500 bg-slate-50 rounded-2xl border border-slate-100 border-dashed">
                        No images uploaded yet.
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($images as $img)
                            <div x-data="{ editMode: false }" class="relative group rounded-xl overflow-hidden shadow-sm border border-slate-100 bg-slate-50">
                                <div x-show="!editMode" class="h-full relative">
                                    <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-40 object-cover">
                                    <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-between p-4">
                                        <div class="self-end flex space-x-2">
                                            <button @click="editMode = true" class="w-8 h-8 bg-indigo-500 text-white rounded-full flex items-center justify-center hover:bg-indigo-600 transition shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            <form action="{{ route('settings.gallery.destroy', $img) }}" method="POST" onsubmit="return confirm('Delete this image?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 bg-rose-500 text-white rounded-full flex items-center justify-center hover:bg-rose-600 transition shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                        <p class="text-white text-xs font-medium truncate">{{ $img->caption }}</p>
                                    </div>
                                </div>
                                <div x-show="editMode" class="p-4 flex flex-col justify-center h-full" style="display: none;">
                                    <form action="{{ route('settings.gallery.update', $img) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Caption</label>
                                        <input type="text" name="caption" value="{{ $img->caption }}" class="w-full text-sm rounded border-slate-300 mb-2 p-1.5 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Caption">
                                        <div class="flex justify-end space-x-2 mt-2">
                                            <button type="button" @click="editMode = false" class="px-3 py-1 text-xs font-bold bg-slate-200 text-slate-700 rounded hover:bg-slate-300 transition">Cancel</button>
                                            <button type="submit" class="px-3 py-1 text-xs font-bold bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
