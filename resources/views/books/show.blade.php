<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('books.index') }}" class="text-slate-400 hover:text-slate-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ $book->title }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-slate-100">
                <div class="p-8 md:p-12">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                        <!-- Book Cover -->
                        <div class="col-span-1">
                            <div class="aspect-[3/4] bg-slate-50 rounded-3xl overflow-hidden shadow-2xl border border-slate-100 flex items-center justify-center">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-slate-200 flex flex-col items-center p-8 text-center">
                                        <svg class="w-24 h-24 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        <span class="text-sm uppercase font-bold tracking-widest leading-tight">No Cover Available</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Book Details -->
                        <div class="col-span-2 space-y-8">
                            <div>
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-widest rounded-full border border-indigo-100">
                                    {{ $book->category }}
                                </span>
                                <h1 class="text-4xl font-black text-slate-900 mt-4 leading-tight">{{ $book->title }}</h1>
                                <p class="text-xl text-slate-500 font-medium mt-2">by {{ $book->author }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-6 py-8 border-y border-slate-50">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Book Type</p>
                                    <p class="text-lg font-bold text-slate-700 capitalize">{{ $book->book_type === 'physical' ? 'Physical (OPAC)' : $book->book_type }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">ISBN / Ref</p>
                                    <p class="text-lg font-bold text-slate-700">{{ $book->isbn ?? 'N/A' }}</p>
                                </div>
                                @if($book->book_type !== 'digital')
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Stock Status</p>
                                    <p class="text-lg font-bold {{ $book->available_quantity > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $book->available_quantity }} / {{ $book->quantity }} Available
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Shelf Location</p>
                                    <p class="text-lg font-bold text-slate-700">{{ $book->shelf_location ?? 'N/A' }}</p>
                                </div>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <h3 class="text-lg font-bold text-slate-800">Abstract / Description</h3>
                                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 text-slate-600 leading-relaxed italic">
                                    {{ $book->abstract ?? 'No description available for this book.' }}
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 pt-4">
                                @if($book->book_type !== 'physical' && $book->pdf_file)
                                    <a href="{{ asset('storage/' . $book->pdf_file) }}" target="_blank" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition shadow-xl shadow-indigo-100 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        Read Digital Copy
                                    </a>
                                @endif

                                @if($book->book_type !== 'digital' && Auth::user()->role === 'student')
                                    <form action="{{ route('books.borrow', $book) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="px-8 py-4 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 transition shadow-xl shadow-emerald-100 flex items-center"
                                                {{ $book->available_quantity <= 0 ? 'disabled' : '' }}>
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                            {{ $book->available_quantity <= 0 ? 'Out of Stock' : 'Borrow Physical (OPAC) Copy' }}
                                        </button>
                                    </form>
                                @endif

                                @if(Auth::user()->role !== 'student')
                                    <a href="{{ route('books.edit', $book) }}" class="px-8 py-4 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 transition">
                                        Edit Book Details
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
