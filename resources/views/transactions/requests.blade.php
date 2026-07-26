<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Borrow Requests') }}
            </h2>
            <a href="{{ route('transactions.index') }}" class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                Back to History
            </a>
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
                <div class="p-6 border-b border-slate-50">
                    <h3 class="text-lg font-bold text-slate-800">Pending Approvals & Returns</h3>
                    <p class="text-xs text-slate-400 mt-1">Review borrow requests and confirm returned physical books.</p>
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-widest">
                            <tr>
                                <th class="px-6 py-4">Book Details</th>
                                <th class="px-6 py-4">Student</th>
                                <th class="px-6 py-4">Request Date</th>
                                <th class="px-6 py-4">Type</th>
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
                                                <div class="text-[10px] text-slate-500 font-bold uppercase tracking-tighter">Stock: {{ $transaction->book->available_quantity }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-700 text-sm">{{ $transaction->student->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-bold">{{ $transaction->student->student_id }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-600">
                                        {{ $transaction->created_at->format('M d, Y') }}
                                        <div class="text-[9px] text-slate-400">{{ $transaction->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($transaction->status === 'requested')
                                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase border bg-amber-50 text-amber-600 border-amber-100">Borrow</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase border bg-indigo-50 text-indigo-600 border-indigo-100">Return</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end space-x-2">
                                            @if($transaction->status === 'requested')
                                                <form action="{{ route('transactions.approve', $transaction) }}" method="POST">
                                                    @csrf
                                                    <button class="px-4 py-2 bg-emerald-600 text-white text-[10px] font-black uppercase rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-100">Approve</button>
                                                </form>
                                                <form action="{{ route('transactions.reject', $transaction) }}" method="POST">
                                                    @csrf
                                                    <button class="px-4 py-2 bg-white text-rose-600 border border-rose-100 text-[10px] font-black uppercase rounded-xl hover:bg-rose-50 transition">Reject</button>
                                                </form>
                                            @elseif($transaction->status === 'pending_return')
                                                <form action="{{ route('transactions.confirmReturn', $transaction) }}" method="POST">
                                                    @csrf
                                                    <button class="px-4 py-2 bg-indigo-600 text-white text-[10px] font-black uppercase rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">Confirm Return</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-20 text-center text-slate-400 italic">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 mb-4 opacity-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <p class="font-bold uppercase tracking-widest text-xs">No pending requests.</p>
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
