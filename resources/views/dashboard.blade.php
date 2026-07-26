<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Overview') }}
            </h2>
            <div class="text-sm text-slate-500 font-medium">
                {{ now()->format('l, jS F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(isset($pendingRequests) && $pendingRequests > 0)
                <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-rose-100 rounded-xl text-rose-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-rose-800">Action Required</h4>
                            <p class="text-sm text-rose-600 mt-0.5">There are <strong>{{ $pendingRequests }}</strong> pending book borrow requests waiting for your approval.</p>
                        </div>
                    </div>
                    <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-rose-600 text-white text-sm font-bold rounded-lg hover:bg-rose-700 transition">
                        Review Requests
                    </a>
                </div>
            @endif

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Books -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
                    <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Books</p>
                        <h3 class="text-3xl font-bold text-slate-800">{{ $totalBooks }}</h3>
                        <p class="text-xs text-slate-400 mt-1">{{ $totalCopies }} total copies</p>
                    </div>
                </div>

                <!-- Total Students -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Students</p>
                        <h3 class="text-3xl font-bold text-slate-800">{{ $totalStudents }}</h3>
                    </div>
                </div>

                <!-- Borrowed Books -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
                    <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Borrowed</p>
                        <h3 class="text-3xl font-bold text-slate-800">{{ $borrowedBooks }}</h3>
                    </div>
                </div>

                <!-- Overdue Books -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
                    <div class="p-3 bg-rose-50 rounded-xl text-rose-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Overdue</p>
                        <h3 class="text-3xl font-bold text-slate-800">{{ $overdueBooks }}</h3>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50">
                    <h3 class="text-lg font-bold text-slate-800">Recent Activity</h3>
                </div>
                <div class="p-0">
                    @forelse($recentActivity as $activity)
                        <div class="p-4 flex items-center space-x-4 border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition">
                            <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center 
                                {{ $activity->status === 'returned' ? 'bg-emerald-50 text-emerald-600' : ($activity->status === 'borrowed' ? 'bg-indigo-50 text-indigo-600' : ($activity->status === 'requested' ? 'bg-amber-50 text-amber-600' : 'bg-rose-50 text-rose-600')) }}">
                                @if($activity->status === 'returned')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @elseif($activity->status === 'borrowed')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                @elseif($activity->status === 'requested')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-slate-800">
                                    <span class="font-bold">{{ $activity->student->name }}</span>
                                    @if($activity->status === 'requested')
                                        requested to borrow
                                    @elseif($activity->status === 'borrowed')
                                        borrowed
                                    @elseif($activity->status === 'returned')
                                        returned
                                    @else
                                        request rejected for
                                    @endif
                                    <span class="font-bold">"{{ $activity->book->title }}"</span>
                                </p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $activity->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                            <svg class="w-12 h-12 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p>No recent activity recorded.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
