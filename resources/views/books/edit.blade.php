<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('books.index') }}" class="text-slate-400 hover:text-slate-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Edit Book') }}: {{ $book->title }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10" x-data="{ bookType: '{{ $book->book_type }}' }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-8 p-4 bg-rose-50 border border-rose-100 rounded-2xl text-rose-700 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Book Type Selection -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-6">What kind of book is this?</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="relative flex items-center p-4 cursor-pointer rounded-2xl border-2 transition" :class="bookType === 'physical' ? 'border-indigo-600 bg-indigo-50' : 'border-slate-100 hover:border-slate-200'">
                            <input type="radio" name="book_type" value="physical" x-model="bookType" class="hidden">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 rounded-lg" :class="bookType === 'physical' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500'">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <span class="font-bold text-slate-800">Physical (OPAC) Book</span>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 cursor-pointer rounded-2xl border-2 transition" :class="bookType === 'digital' ? 'border-emerald-600 bg-emerald-50' : 'border-slate-100 hover:border-slate-200'">
                            <input type="radio" name="book_type" value="digital" x-model="bookType" class="hidden">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 rounded-lg" :class="bookType === 'digital' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-500'">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <span class="font-bold text-slate-800">Digital (eBook)</span>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 cursor-pointer rounded-2xl border-2 transition" :class="bookType === 'hybrid' ? 'border-indigo-600 bg-indigo-50' : 'border-slate-100 hover:border-slate-200'">
                            <input type="radio" name="book_type" value="hybrid" x-model="bookType" class="hidden">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 rounded-lg" :class="bookType === 'hybrid' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500'">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V7m-7 4h10m-6 0a2 2 0 002 2h2a2 2 0 002-2M9 21h12a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 002 2z"></path></svg>
                                </div>
                                <span class="font-bold text-slate-800">Hybrid (Both)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Core Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Book Title</label>
                            <input type="text" name="title" value="{{ old('title', $book->title) }}" placeholder="e.g. Clinical Nursing Practice" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Author</label>
                            <input type="text" name="author" value="{{ old('author', $book->author) }}" placeholder="e.g. Dr. Alabi Williams" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">ISBN</label>
                            <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" placeholder="e.g. 978-3-16-148410-0" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Category</label>
                            <select name="category" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition">
                                @foreach(['Medical Sciences', 'Community Health', 'Pharmacy Technology', 'Environmental Health', 'Dental Health', 'General Science'] as $cat)
                                    <option value="{{ $cat }}" {{ (old('category', $book->category) == $cat) ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Department <span class="text-slate-400 font-normal">(optional)</span></label>
                            <select name="department_id" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <option value="">— Not Assigned —</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id', $book->department_id) == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}{{ $dept->code ? ' ('.$dept->code.')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2 mt-6">
                        <label class="text-sm font-semibold text-slate-700">Book Abstract / Summary</label>
                        <textarea name="abstract" rows="4" placeholder="Briefly describe what this book is about..." class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition">{{ old('abstract', $book->abstract) }}</textarea>
                    </div>

                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-6" x-show="bookType !== 'digital'">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Physical Inventory & Location</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Total Quantity</label>
                            <input type="number" name="quantity" value="{{ old('quantity', $book->quantity) }}" min="1" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition" :required="bookType !== 'digital'">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Shelf Location</label>
                            <input type="text" name="shelf_location" value="{{ old('shelf_location', $book->shelf_location) }}" placeholder="e.g. A-12" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Media & Files</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <label class="text-sm font-semibold text-slate-700">Cover Image</label>
                            @if($book->cover_image)
                                <div class="w-20 h-28 bg-slate-100 rounded-lg overflow-hidden border border-slate-200">
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <input type="file" name="cover_image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                        </div>
                        <div class="space-y-4" x-show="bookType !== 'physical'">
                            <label class="text-sm font-semibold text-slate-700">Digital Copy (PDF)</label>
                            @if($book->pdf_file)
                                <div class="flex items-center text-xs text-emerald-600 bg-emerald-50 px-3 py-2 rounded-lg border border-emerald-100 font-bold w-fit">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    PDF Uploaded
                                </div>
                            @endif
                            <input type="file" name="pdf_file" accept=".pdf" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition" :required="bookType === 'digital' && !'{{ $book->pdf_file }}'">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('books.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition shadow-xl shadow-indigo-100">
                        Update Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
