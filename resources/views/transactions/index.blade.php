<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ Auth::user()->role === 'student' ? __('My Borrowing History') : __('All Services') }}
            </h2>
            @if(Auth::user()->role !== 'student')
                <div class="flex space-x-3">
                    <a href="{{ route('transactions.requests') }}" class="px-5 py-2.5 bg-amber-500 text-white text-sm font-bold rounded-xl hover:bg-amber-600 transition shadow-sm flex items-center">
                        <span class="mr-2">Pending Requests</span>
                        <span class="bg-white text-amber-600 px-2 py-0.5 rounded-full text-[10px]">{{ \App\Models\Transaction::where('status', 'requested')->count() }}</span>
                    </a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl text-rose-700 text-sm font-semibold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-widest">
                            <tr>
                                <th class="px-6 py-4">Book Details</th>
                                @if(Auth::user()->role !== 'student')
                                    <th class="px-6 py-4">Student</th>
                                @endif
                                <th class="px-6 py-4">Borrowed/Due</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($transactions as $transaction)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-14 bg-slate-100 rounded-lg overflow-hidden border border-slate-100">
                                                @if($transaction->book->cover_image)
                                                    <img src="{{ asset('storage/' . $transaction->book->cover_image) }}" class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800 text-sm">{{ $transaction->book->title }}</div>
                                                <div class="text-[10px] text-slate-500 font-bold uppercase tracking-tighter">{{ $transaction->book->category }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    @if(Auth::user()->role !== 'student')
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-slate-700 text-sm">{{ $transaction->student->name }}</div>
                                            <div class="text-[10px] text-slate-400 font-bold">{{ $transaction->student->student_id }}</div>
                                        </td>
                                    @endif
                                    <td class="px-6 py-4">
                                        @if($transaction->status === 'requested')
                                            <span class="text-xs text-slate-400 italic">Awaiting Approval</span>
                                        @elseif($transaction->status === 'pending_return')
                                            <span class="text-xs text-slate-400 italic">Return Pending Confirmation</span>
                                        @else
                                            <div class="text-xs">
                                                <div class="flex items-center text-slate-600">
                                                    <span class="w-12 text-[10px] font-bold uppercase text-slate-400">Out:</span>
                                                    <span>{{ $transaction->borrowed_at }}</span>
                                                </div>
                                                <div class="flex items-center mt-1 {{ ($transaction->status === 'borrowed' && now() > $transaction->due_date) ? 'text-rose-600' : 'text-slate-600' }}">
                                                    <span class="w-12 text-[10px] font-bold uppercase text-slate-400">Due:</span>
                                                    <span>{{ $transaction->due_date }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'requested' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                'pending_return' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                'borrowed' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                                'returned' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                'rejected' => 'bg-rose-50 text-rose-600 border-rose-100',
                                            ];
                                            $status = $transaction->status;
                                            if ($status === 'borrowed' && now() > $transaction->due_date) {
                                                $status = 'overdue';
                                                $statusColors['overdue'] = 'bg-rose-600 text-white border-rose-600';
                                            }
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase border {{ $statusColors[$status] ?? 'bg-slate-50 text-slate-600' }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if(Auth::user()->role !== 'student')
                                            @if($transaction->status === 'requested')
                                                <div class="flex justify-end space-x-2">
                                                    <form action="{{ route('transactions.approve', $transaction) }}" method="POST">
                                                        @csrf
                                                        <button class="px-3 py-1 bg-emerald-600 text-white text-[10px] font-bold uppercase rounded-lg hover:bg-emerald-700 transition">Approve</button>
                                                    </form>
                                                    <form action="{{ route('transactions.reject', $transaction) }}" method="POST">
                                                        @csrf
                                                        <button class="px-3 py-1 bg-white text-rose-600 border border-rose-100 text-[10px] font-bold uppercase rounded-lg hover:bg-rose-50 transition">Reject</button>
                                                    </form>
                                                </div>
                                            @elseif($transaction->status === 'borrowed')
                                                <form action="{{ route('transactions.return', $transaction) }}" method="POST">
                                                    @csrf
                                                    <button class="px-4 py-2 bg-indigo-600 text-white text-[10px] font-bold uppercase rounded-xl hover:bg-indigo-700 transition shadow-md shadow-indigo-100">Mark Returned</button>
                                                </form>
                                            @elseif($transaction->status === 'pending_return')
                                                <form action="{{ route('transactions.confirmReturn', $transaction) }}" method="POST">
                                                    @csrf
                                                    <button class="px-4 py-2 bg-emerald-600 text-white text-[10px] font-bold uppercase rounded-xl hover:bg-emerald-700 transition shadow-md shadow-emerald-100">Confirm Return</button>
                                                </form>
                                            @endif
                                        @else
                                            @if($transaction->status === 'requested')
                                                <span class="text-[10px] text-slate-400 font-bold uppercase italic">Pending...</span>
                                            @elseif($transaction->status === 'pending_return')
                                                <span class="text-[10px] text-amber-500 font-bold uppercase italic">Awaiting Confirmation</span>
                                            @elseif($transaction->status === 'borrowed')
                                                <form action="{{ route('transactions.return', $transaction) }}" method="POST" onsubmit="return confirm('Mark this book as returned?');">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 bg-emerald-600 text-white text-[10px] font-bold uppercase rounded-lg hover:bg-emerald-700 transition shadow-sm">Return Book</button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 mb-4 opacity-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            <p class="font-bold uppercase tracking-widest text-xs">No transactions yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
