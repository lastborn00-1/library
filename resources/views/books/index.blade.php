<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Books') }}
            </h2>
            @if(Auth::user()->role !== 'student')
                <a href="{{ route('books.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition shadow-sm">
                    Add New Book
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-10"
         x-data="{
            searchQuery: '{{ request('search') }}',
            selectedAbstract: '',
            showModal: false,
            viewLayout: 'list',

            logActivity(bookId, actionType) {
                if ('{{ Auth::user()->role }}' !== 'student') return;
                fetch('{{ route('activity-logs.store') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ book_id: bookId, action_type: actionType })
                }).catch(err => console.error(err));
            }
         }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 text-sm font-semibold animate-fade-in">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filters & View Toggle -->
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center p-1 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-x-auto">
                    <a href="{{ route('books.index') }}" class="whitespace-nowrap px-6 py-2 rounded-xl text-sm font-bold transition {{ !request('type') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-slate-500 hover:text-slate-700' }}">
                        All Books
                    </a>
                    <a href="{{ route('books.index', ['type' => 'physical']) }}" class="whitespace-nowrap px-6 py-2 rounded-xl text-sm font-bold transition {{ request('type') == 'physical' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-slate-500 hover:text-slate-700' }}">
                        Physical (OPAC)
                    </a>
                    <a href="{{ route('books.index', ['type' => 'digital']) }}" class="whitespace-nowrap px-6 py-2 rounded-xl text-sm font-bold transition {{ request('type') == 'digital' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-slate-500 hover:text-slate-700' }}">
                        Digital (eBooks)
                    </a>
                    <a href="{{ route('books.index', ['type' => 'hybrid']) }}" class="whitespace-nowrap px-6 py-2 rounded-xl text-sm font-bold transition {{ request('type') == 'hybrid' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-slate-500 hover:text-slate-700' }}">
                        Hybrid
                    </a>
                </div>

                <div class="flex items-center space-x-2">
                    <form action="{{ route('books.index') }}" method="GET" class="flex-grow sm:flex-grow-0 flex flex-col sm:flex-row gap-2">
                        @if(request('type'))
                            <input type="hidden" name="type" value="{{ request('type') }}">
                        @endif
                        
                        <select name="department" class="w-full sm:w-48 bg-white border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition" onchange="this.form.submit()">
                            <option value="">All Departments</option>
                            @if(isset($departments))
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            @endif
                        </select>

                        <div class="relative w-full sm:w-64">
                            <input type="text" x-model="searchQuery" name="search" value="{{ request('search') }}" placeholder="Search titles, authors..." class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>
                    </form>

                    <div class="flex items-center p-1 bg-white rounded-2xl border border-slate-100 shadow-sm">
                        <button @click="viewLayout = 'list'" :class="viewLayout === 'list' ? 'bg-slate-800 text-white shadow-lg' : 'text-slate-500 hover:text-slate-700'" class="p-2 rounded-xl transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                        <button @click="viewLayout = 'grid'" :class="viewLayout === 'grid' ? 'bg-slate-800 text-white shadow-lg' : 'text-slate-500 hover:text-slate-700'" class="p-2 rounded-xl transition ml-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                
                <!-- Book Collection Header -->
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-xl font-bold text-slate-800">Book Collection</h2>
                </div>

                <!-- List View -->
                <div x-show="viewLayout === 'list'" class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Book Info</th>
                                    <th class="px-6 py-4 font-semibold">Type</th>
                                    <th class="px-6 py-4 font-semibold">Department & Category</th>
                                    <th class="px-6 py-4 font-semibold">Inventory</th>
                                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse ($books as $book)
                                    <tr class="hover:bg-slate-50/50 transition" x-show="searchQuery === '' || $el.innerText.toLowerCase().includes(searchQuery.toLowerCase())">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-12 h-16 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0 border border-slate-100 shadow-sm">
                                                    @if($book->cover_image)
                                                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-slate-300 italic text-[10px]">No Cover</div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-bold text-slate-800 leading-tight">{{ $book->title }}</div>
                                                    <div class="text-xs text-slate-500 mt-0.5">{{ $book->author }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($book->book_type === 'digital')
                                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase border border-emerald-100">Digital</span>
                                            @elseif($book->book_type === 'hybrid')
                                                <span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase border border-indigo-100">Hybrid</span>
                                            @else
                                                <span class="px-2.5 py-1 rounded-lg bg-slate-50 text-slate-600 text-[10px] font-bold uppercase border border-slate-100">Physical (OPAC)</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col gap-1">
                                                <span class="text-xs font-bold text-slate-700">{{ $book->department ? $book->department->name : 'No Department' }}</span>
                                                <span class="text-xs text-slate-500">{{ $book->category }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($book->book_type === 'digital')
                                                <span class="text-xs font-bold text-emerald-600 italic">Unlimited</span>
                                            @else
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-bold text-slate-700">{{ $book->available_quantity }} / {{ $book->quantity }}</span>
                                                    <span class="text-[10px] text-indigo-400 font-bold uppercase tracking-tighter">Loc: {{ $book->shelf_location ?? 'N/A' }}</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end space-x-3">
                                                @if($book->book_type !== 'physical' && $book->pdf_file)
                                                    <button onclick="window.openPdfReader('{{ asset('storage/' . $book->pdf_file) }}')" class="text-emerald-600 hover:text-emerald-800 text-xs font-bold bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100 transition">Read</button>
                                                @endif

                                                @if($book->book_type !== 'digital' && Auth::user()->role === 'student')
                                                    <form action="{{ route('books.borrow', $book) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="text-white hover:bg-emerald-700 text-xs font-bold bg-emerald-600 px-3 py-1.5 rounded-lg transition"
                                                                {{ $book->available_quantity <= 0 ? 'disabled opacity-50' : '' }}>
                                                            Borrow
                                                        </button>
                                                    </form>
                                                @endif

                                                <button @click="selectedAbstract = {{ json_encode($book->abstract) }}; showModal = true; logActivity({{ $book->id }}, 'preview_abstract')" class="text-slate-600 hover:text-slate-800 text-xs font-bold bg-white border border-slate-200 px-3 py-1.5 rounded-lg transition">Preview</button>
                                                
                                                @if(Auth::user()->role !== 'student')
                                                <a href="{{ route('books.edit', $book) }}" class="text-slate-400 hover:text-indigo-600 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Delete?');">
                                                    @csrf @method('DELETE')
                                                    <button class="text-slate-400 hover:text-rose-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">No books found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Grid View -->
                <div x-show="viewLayout === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse ($books as $book)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col h-full hover:shadow-md transition duration-300" x-show="searchQuery === '' || $el.innerText.toLowerCase().includes(searchQuery.toLowerCase())">
                            <!-- Image -->
                            <div class="aspect-[3/4] bg-slate-50 relative overflow-hidden flex items-center justify-center">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-slate-200 flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        <span class="text-[9px] uppercase font-bold tracking-widest px-4 text-center leading-tight">{{ $book->title }}</span>
                                    </div>
                                @endif
                                
                                <div class="absolute top-3 left-3">
                                    <span class="px-2 py-1 rounded-md text-[9px] font-bold uppercase shadow-sm {{ $book->book_type === 'digital' ? 'bg-emerald-600 text-white' : ($book->book_type === 'hybrid' ? 'bg-indigo-600 text-white' : 'bg-slate-700 text-white') }}">
                                        {{ $book->book_type === 'physical' ? 'Physical (OPAC)' : $book->book_type }}
                                    </span>
                                </div>
                            </div>

                            <!-- Info -->
                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="font-bold text-slate-800 text-sm mb-1 line-clamp-2 leading-tight">{{ $book->title }}</h3>
                                <p class="text-[11px] text-slate-500 mb-4">by {{ $book->author }}</p>
                                
                                <div class="mt-auto">
                                    <div class="flex items-center justify-between text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">
                                        <span class="truncate pr-2" title="{{ $book->department ? $book->department->name : 'No Dept' }}">
                                            {{ $book->department ? Str::limit($book->department->name, 15) : 'No Dept' }}
                                        </span>
                                        <span class="truncate">{{ $book->category }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-4">
                                        @if($book->book_type !== 'digital')
                                            <span>Stock: {{ $book->available_quantity }}</span>
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-2 gap-2">
                                        @if($book->book_type !== 'physical' && $book->pdf_file)
                                            <button onclick="window.openPdfReader('{{ asset('storage/' . $book->pdf_file) }}')" 
                                                    class="flex items-center justify-center py-2.5 bg-indigo-600 text-white text-[10px] font-black uppercase rounded-xl hover:bg-indigo-700 transition shadow-sm">
                                                Read
                                            </button>
                                        @endif
                                        <button @click="selectedAbstract = {{ json_encode($book->abstract) }}; showModal = true; logActivity({{ $book->id }}, 'preview_abstract')" 
                                                class="flex items-center justify-center py-2.5 bg-slate-100 text-slate-700 text-[10px] font-black uppercase rounded-xl hover:bg-slate-200 transition {{ ($book->book_type === 'physical' || !$book->pdf_file) ? 'col-span-2' : '' }}">
                                            Preview
                                        </button>
                                    </div>

                                    @if($book->book_type !== 'digital' && Auth::user()->role === 'student')
                                        <form action="{{ route('books.borrow', $book) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full mt-2 flex items-center justify-center py-2.5 bg-emerald-600 text-white text-[10px] font-black uppercase rounded-xl hover:bg-emerald-700 transition shadow-md shadow-emerald-100"
                                                    {{ $book->available_quantity <= 0 ? 'disabled opacity-50 cursor-not-allowed' : '' }}>
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                {{ $book->available_quantity <= 0 ? 'Out of Stock' : 'Borrow Physical (OPAC)' }}
                                            </button>
                                        </form>
                                    @endif

                                    @if(Auth::user()->role !== 'student')
                                    <div class="flex justify-end space-x-2 pt-4 mt-4 border-t border-slate-50">
                                        <a href="{{ route('books.edit', $book) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Delete this book?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center text-slate-400 italic bg-white rounded-3xl border border-dashed border-slate-200">
                            No books found matching this filter.
                        </div>
                    @endforelse
                </div>

                <!-- Abstract Modal -->
                <div x-show="showModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                     style="display: none;"
                     @keydown.escape.window="showModal = false">
                    <div class="bg-white rounded-3xl shadow-2xl z-[70] max-w-2xl w-full p-8 transform transition-all" @click.away="showModal = false">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold text-slate-800">Book Abstract</h3>
                            <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="text-slate-600 leading-relaxed text-lg italic bg-slate-50 p-6 rounded-2xl border border-slate-100 max-h-96 overflow-y-auto" x-text="selectedAbstract"></div>
                        <div class="mt-8 flex justify-end">
                            <button @click="showModal = false" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition">Close Preview</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== STANDALONE PDF READER (Vanilla JS + PDF.js) ===== -->
    <div id="kwcht-pdf-reader" style="display:none; position:fixed; inset:0; z-index:9999; background:#0f172a; flex-direction:column;">

        <!-- Toolbar (Auto-hiding in Slide Mode) -->
        <div id="reader-toolbar" style="height:60px; background:#020617; display:flex; align-items:center; justify-content:space-between; padding:0 20px; flex-shrink:0; border-bottom:1px solid #1e293b; transition: transform 0.3s ease; z-index:200;">
            <div style="display:flex; align-items:center; gap:12px;">
                <div style="width:36px; height:36px; background:linear-gradient(135deg, #6366f1, #4f46e5); border-radius:10px; display:flex; align-items:center; justify-content:center; shadow:0 4px 12px rgba(99,102,241,0.3);">
                    <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <span style="color:white; font-weight:700; font-size:13px; text-transform:uppercase; letter-spacing:1px; font-family:system-ui;">KWCHT Reader</span>

                <!-- Mode Toggle -->
                <div style="display:flex; background:#1e293b; border-radius:10px; padding:3px; border:1px solid #334155; margin-left:10px;">
                    <button id="btn-scroll-mode" onclick="kwchtReader.setMode('scroll')" style="padding:5px 14px; border-radius:7px; border:none; font-size:11px; font-weight:700; cursor:pointer; background:#4f46e5; color:white; transition:all 0.2s;">Scroll</button>
                    <button id="btn-slide-mode" onclick="kwchtReader.setMode('slide')" style="padding:5px 14px; border-radius:7px; border:none; font-size:11px; font-weight:700; cursor:pointer; background:transparent; color:#94a3b8; transition:all 0.2s;">Slide</button>
                </div>

                <div id="slide-nav-mini" style="display:none; align-items:center; color:#64748b; font-size:11px; font-weight:700; margin-left:15px; border-left:1px solid #334155; padding-left:15px;">
                    <span id="page-indicator">Page 0 / 0</span>
                </div>
            </div>

            <button onclick="kwchtReader.close()" style="background:none; border:none; cursor:pointer; color:#64748b; display:flex; align-items:center; padding:8px; border-radius:10px; transition:all 0.2s;" onmouseover="this.style.color='white'; this.style.background='#1e293b'" onmouseout="this.style.color='#64748b'; this.style.background='none'">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Content -->
        <div id="reader-content" style="flex:1; overflow:hidden; position:relative;">
            <!-- Scroll mode: iframe -->
            <iframe id="reader-iframe" src="" style="width:100%; height:100%; border:none; display:block;"></iframe>

            <!-- Slide mode: Triple-canvas Stack Animation -->
            <div id="reader-slide" style="display:none; width:100%; height:100%; background:radial-gradient(circle, #1e293b 0%, #0f172a 100%); align-items:center; justify-content:center; position:relative; overflow:hidden;">
                
                <div id="reader-loading" style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center; z-index:50; background:rgba(15,23,42,0.5); backdrop-blur:sm;">
                    <div style="width:48px; height:48px; border:4px solid #6366f1; border-top-color:transparent; border-radius:50%; animation:spin 0.8s linear infinite;"></div>
                </div>

                <!-- Navigation Controls (On-Screen) -->
                <button onclick="kwchtReader.prev()" id="btn-reader-prev" style="position:absolute; left:20px; top:50%; transform:translateY(-50%); z-index:100; width:56px; height:56px; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; cursor:pointer; backdrop-filter:blur(8px); transition:all 0.3s ease; opacity:0.5;" onmouseover="this.style.opacity='1'; this.style.background='rgba(99,102,241,0.4)'" onmouseout="this.style.opacity='0.5'; this.style.background='rgba(255,255,255,0.1)'">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>

                <button onclick="kwchtReader.next()" id="btn-reader-next" style="position:absolute; right:20px; top:50%; transform:translateY(-50%); z-index:100; width:56px; height:56px; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; cursor:pointer; backdrop-filter:blur(8px); transition:all 0.3s ease; opacity:0.5;" onmouseover="this.style.opacity='1'; this.style.background='rgba(99,102,241,0.4)'" onmouseout="this.style.opacity='0.5'; this.style.background='rgba(255,255,255,0.1)'">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>

                <!-- Infinite Chain Strip -->
                <div id="chain-viewport" style="width:100%; height:100%; overflow:hidden; position:relative; display:flex; align-items:center; justify-content:center;">
                    <div id="reader-strip" style="display:flex; height:100%; position:absolute; left:0; top:0; transition: transform 0.5s cubic-bezier(0.23, 1, 0.32, 1); will-change: transform;">
                        <div class="chain-page-box"><canvas id="cp-2" class="chain-canvas"></canvas></div>
                        <div class="chain-page-box"><canvas id="cp-1" class="chain-canvas"></canvas></div>
                        <div class="chain-page-box"><canvas id="cp0"  class="chain-canvas"></canvas></div>
                        <div class="chain-page-box"><canvas id="cp1"  class="chain-canvas"></canvas></div>
                        <div class="chain-page-box"><canvas id="cp2"  class="chain-canvas"></canvas></div>
                    </div>
                </div>

                <!-- Floating Page Indicator -->
                <div style="position:absolute; bottom:30px; left:50%; transform:translateX(-50%); background:rgba(15,23,42,0.8); border:1px solid rgba(99,102,241,0.3); padding:8px 20px; border-radius:30px; color:white; font-weight:700; font-size:14px; backdrop-filter:blur(10px); z-index:110; pointer-events:none; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
                    <span id="floating-page-num">0</span> / <span id="floating-page-total">0</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes spin { to { transform: rotate(360deg); } }
        .chain-page-box { 
            width: 100vw; 
            height: 100%; 
            flex-shrink: 0; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 20px;
        }
        .chain-canvas { 
            max-width: 95%; 
            max-height: 95%; 
            background: white; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.5); 
            border-radius: 4px;
            opacity: 1;
            transition: opacity 0.3s;
        }
        
        .nav-active #reader-toolbar { transform: translateY(0); }
        .nav-hidden #reader-toolbar { transform: translateY(-100%); }
    </style>

    <script>
        const kwchtReader = {
            pdfDoc: null,
            pageNum: 1,
            pageCount: 0,
            rendering: false,
            url: '',
            
            async open(url) {
                this.url = url;
                this.pageNum = 1;
                this.pdfDoc = null;
                this.setMode('scroll');
                document.getElementById('kwcht-pdf-reader').style.display = 'flex';
                document.getElementById('reader-iframe').src = url + '#toolbar=0&navpanes=0';
                document.body.style.overflow = 'hidden';
            },

            close() {
                document.getElementById('kwcht-pdf-reader').style.display = 'none';
                document.getElementById('reader-iframe').src = '';
                document.body.style.overflow = '';
                this.pdfDoc = null;
            },

            setMode(mode) {
                const wrap = document.getElementById('kwcht-pdf-reader');
                if (mode === 'scroll') {
                    document.getElementById('btn-scroll-mode').style.background = '#4f46e5';
                    document.getElementById('btn-slide-mode').style.background = 'transparent';
                    document.getElementById('reader-iframe').style.display = 'block';
                    document.getElementById('reader-slide').style.display = 'none';
                    document.getElementById('slide-nav-mini').style.display = 'none';
                } else {
                    document.getElementById('btn-slide-mode').style.background = '#4f46e5';
                    document.getElementById('btn-scroll-mode').style.background = 'transparent';
                    document.getElementById('reader-iframe').style.display = 'none';
                    document.getElementById('reader-slide').style.display = 'flex';
                    document.getElementById('slide-nav-mini').style.display = 'flex';
                    this.loadPdf();
                }
            },

            async loadPdf() {
                if (!this.pdfDoc) {
                    document.getElementById('reader-loading').style.display = 'flex';
                    const task = pdfjsLib.getDocument(this.url);
                    this.pdfDoc = await task.promise;
                    this.pageCount = this.pdfDoc.numPages;
                    document.getElementById('floating-page-total').textContent = this.pageCount;
                }
                this.updateStrip(true);
            },

            async renderPage(num, canvasId) {
                const canvas = document.getElementById(canvasId);
                if (num < 1 || num > this.pageCount) {
                    canvas.style.opacity = '0';
                    return;
                }
                canvas.style.opacity = '1';
                try {
                    const page = await this.pdfDoc.getPage(num);
                    const vp = page.getViewport({ scale: 1 });
                    const scale = Math.min((window.innerWidth * 0.9) / vp.width, (window.innerHeight * 0.9) / vp.height);
                    const viewport = page.getViewport({ scale });
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;
                    await page.render({ canvasContext: canvas.getContext('2d'), viewport }).promise;
                } catch(e) { console.error(e); }
            },

            async updateStrip(immediate = false) {
                if (this.rendering) return;
                this.rendering = true;
                if (immediate) document.getElementById('reader-loading').style.display = 'flex';

                const strip = document.getElementById('reader-strip');
                if (immediate) {
                    strip.style.transition = 'none';
                    strip.style.transform = `translateX(-200vw)`; // center is cp0
                }

                // Render window of 5
                await Promise.all([
                    this.renderPage(this.pageNum - 2, 'cp-2'),
                    this.renderPage(this.pageNum - 1, 'cp-1'),
                    this.renderPage(this.pageNum,     'cp0'),
                    this.renderPage(this.pageNum + 1, 'cp1'),
                    this.renderPage(this.pageNum + 2, 'cp2')
                ]);

                document.getElementById('floating-page-num').textContent = this.pageNum;
                document.getElementById('page-indicator').textContent = `Page ${this.pageNum} / ${this.pageCount}`;
                document.getElementById('btn-reader-prev').style.opacity = this.pageNum <= 1 ? '0' : '0.5';
                document.getElementById('btn-reader-next').style.opacity = this.pageNum >= this.pageCount ? '0' : '0.5';

                if (immediate) setTimeout(() => strip.style.transition = '', 50);
                document.getElementById('reader-loading').style.display = 'none';
                this.rendering = false;
            },

            next() {
                if (this.pageNum >= this.pageCount || this.rendering) return;
                const strip = document.getElementById('reader-strip');
                this.rendering = true;
                
                // Slide to the next canvas box (from -200vw to -300vw)
                strip.style.transform = `translateX(-300vw)`;
                
                setTimeout(() => {
                    this.pageNum++;
                    strip.style.transition = 'none';
                    strip.style.transform = `translateX(-200vw)`; // Teleport back to logical center
                    this.rendering = false;
                    this.updateStrip(); 
                    setTimeout(() => strip.style.transition = '', 50);
                }, 500);
            },

            prev() {
                if (this.pageNum <= 1 || this.rendering) return;
                const strip = document.getElementById('reader-strip');
                this.rendering = true;
                
                strip.style.transform = `translateX(-100vw)`;
                
                setTimeout(() => {
                    this.pageNum--;
                    strip.style.transition = 'none';
                    strip.style.transform = `translateX(-200vw)`;
                    this.rendering = false;
                    this.updateStrip();
                    setTimeout(() => strip.style.transition = '', 50);
                }, 500);
            }
        };

        window.openPdfReader = (url) => kwchtReader.open(url);

        document.addEventListener('keydown', e => {
            if (document.getElementById('kwcht-pdf-reader').style.display === 'flex') {
                if (e.key === 'ArrowRight') kwchtReader.next();
                if (e.key === 'ArrowLeft') kwchtReader.prev();
                if (e.key === 'Escape') kwchtReader.close();
            }
        });

        let touchStart = 0;
        document.getElementById('reader-slide').addEventListener('touchstart', e => { touchStart = e.changedTouches[0].screenX; }, false);
        document.getElementById('reader-slide').addEventListener('touchend', e => {
            const diff = touchStart - e.changedTouches[0].screenX;
            if (Math.abs(diff) > 60) {
                if (diff > 0) kwchtReader.next();
                else kwchtReader.prev();
            }
        }, false);
    </script>

</x-app-layout>
