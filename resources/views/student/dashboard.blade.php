<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Student Dashboard') }}
            </h2>
            <div class="text-sm text-slate-500 font-medium bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-100">
                Welcome back, <span class="text-indigo-600 font-bold">{{ $student->name }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center space-x-4">
                    <div class="p-3 bg-indigo-50 rounded-2xl text-indigo-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Read</p>
                        <h3 class="text-2xl font-black text-slate-800">{{ $stats['total_read'] }}</h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center space-x-4">
                    <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Currently Holding</p>
                        <h3 class="text-2xl font-black text-slate-800">{{ $stats['currently_holding'] }}</h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center space-x-4">
                    <div class="p-3 bg-amber-50 rounded-2xl text-amber-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pending Requests</p>
                        <h3 class="text-2xl font-black text-slate-800">{{ $stats['pending'] }}</h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center space-x-4">
                    <div class="p-3 bg-rose-50 rounded-2xl text-rose-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Overdue</p>
                        <h3 class="text-2xl font-black text-slate-800 text-rose-600">{{ $stats['overdue'] }}</h3>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Active Borrows -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-slate-800">My Active Books</h3>
                            <a href="{{ route('books.index') }}" class="text-xs font-bold text-indigo-600 hover:underline">Browse More</a>
                        </div>
                        <div class="p-0">
                            @forelse ($currentlyBorrowed as $borrow)
                                <div class="p-6 flex items-center justify-between border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-16 bg-slate-100 rounded-xl overflow-hidden border border-slate-100 shadow-sm flex-shrink-0">
                                            @if($borrow->book->cover_image)
                                                <img src="{{ asset('storage/' . $borrow->book->cover_image) }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-sm">{{ $borrow->book->title }}</h4>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $borrow->book->author }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Due Date</div>
                                        <div class="px-3 py-1 rounded-lg {{ now() > $borrow->due_date ? 'bg-rose-50 text-rose-600' : 'bg-indigo-50 text-indigo-600' }} text-xs font-black mb-2 inline-block">
                                            {{ \Carbon\Carbon::parse($borrow->due_date)->format('M d, Y') }}
                                        </div>
                                        <form action="{{ route('transactions.return', $borrow) }}" method="POST" onsubmit="return confirm('Mark this book as returned?');">
                                            @csrf
                                            <button type="submit" class="w-full px-3 py-1.5 bg-emerald-600 text-white text-[10px] font-bold uppercase rounded-lg hover:bg-emerald-700 transition shadow-sm">Return Book</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="p-12 text-center text-slate-400 italic">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-4 opacity-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        <p class="text-xs font-bold uppercase tracking-widest">You have no active borrows.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Pending Requests -->
                    @if($pendingRequests->isNotEmpty())
                        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                            <div class="p-6 border-b border-slate-50">
                                <h3 class="text-lg font-bold text-slate-800">Pending Requests</h3>
                            </div>
                            <div class="p-0">
                                @foreach ($pendingRequests as $request)
                                    <div class="p-4 flex items-center justify-between border-b border-slate-50 last:border-0">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-10 bg-slate-100 rounded-lg overflow-hidden border border-slate-100">
                                                @if($request->book->cover_image)
                                                    <img src="{{ asset('storage/' . $request->book->cover_image) }}" class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-800 text-xs">{{ $request->book->title }}</h4>
                                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tight">Requested {{ $request->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <span class="px-2 py-1 bg-amber-50 text-amber-600 text-[9px] font-black uppercase rounded-lg border border-amber-100">Awaiting Approval</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- History & Profile -->
                <div class="space-y-8">
                    <!-- Student Profile Card -->
                    <div class="bg-indigo-600 rounded-3xl p-6 text-white shadow-lg shadow-indigo-100">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-xl font-black">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-lg leading-tight">{{ $student->name }}</h3>
                                <p class="text-indigo-200 text-xs font-medium">{{ $student->student_id }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-xs">
                                <span class="text-indigo-200 font-bold uppercase tracking-widest">Class</span>
                                <span class="font-black">{{ $student->class }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-indigo-200 font-bold uppercase tracking-widest">Department</span>
                                <span class="font-black">{{ $student->department ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-indigo-200 font-bold uppercase tracking-widest">Status</span>
                                <span class="px-2 py-0.5 bg-white/20 rounded text-[10px] font-black uppercase">Active Member</span>
                            </div>
                        </div>
                    </div>

                    <!-- Recent History -->
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                            <h3 class="text-sm font-bold text-slate-800">Recent Activity</h3>
                        </div>
                        <div class="p-0">
                            @forelse ($borrowHistory as $history)
                                <div class="p-4 flex items-center space-x-3 border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition">
                                    <div class="w-8 h-8 rounded-xl flex-shrink-0 flex items-center justify-center 
                                        {{ $history['type'] === 'activity' ? 'bg-indigo-50 text-indigo-600' : ($history['status'] === 'returned' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600') }}">
                                        @if($history['type'] === 'activity')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        @elseif($history['status'] === 'returned')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold text-slate-700 truncate">{{ $history['book_title'] }}</p>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ $history['status'] }} • {{ \Carbon\Carbon::parse($history['date'])->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center text-slate-400 text-xs italic">No activity yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
