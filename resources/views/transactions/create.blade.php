<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('transactions.index') }}" class="text-slate-400 hover:text-slate-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('New Book Borrowing') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('transactions.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Borrowing Details</h3>
                    
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Select Student</label>
                            <select name="student_id" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                                <option value="">-- Choose Student --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->student_id }})</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Select Book</label>
                            <select name="book_id" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                                <option value="">-- Choose Book --</option>
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }} - {{ $book->author }} ({{ $book->quantity_available }} available)</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Return Date</label>
                                <input type="date" name="due_date" value="{{ now()->addDays(7)->format('Y-m-d') }}" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('transactions.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition shadow-xl shadow-indigo-100">
                        Process Borrowing
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
