<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('departments.index') }}" class="text-slate-500 hover:text-slate-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">{{ $department->name }}</h2>
                @if($department->code)
                    <span class="text-sm text-slate-400">Code: {{ $department->code }}</span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Department Info Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-8">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <h3 class="text-2xl font-extrabold text-slate-900">{{ $department->name }}</h3>
                            @if($department->status === 'active')
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full">Active</span>
                            @else
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 text-xs font-bold rounded-full">Inactive</span>
                            @endif
                        </div>
                        @if($department->description)
                            <p class="text-slate-500 leading-relaxed max-w-2xl">{{ $department->description }}</p>
                        @endif
                    </div>
                    <a href="{{ route('departments.edit', $department) }}" class="px-5 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition text-sm">
                        Edit Department
                    </a>
                </div>
                <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-indigo-50 rounded-2xl">
                        <div class="text-3xl font-extrabold text-indigo-700">{{ $books->total() }}</div>
                        <div class="text-sm text-indigo-500 font-medium mt-1">Total Books</div>
                    </div>
                </div>
            </div>

            {{-- Books in this Department --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-800">Books in this Department</h3>
                    <a href="{{ route('books.create') }}" class="text-sm text-indigo-600 font-semibold hover:text-indigo-800 transition">+ Add Book</a>
                </div>

                @if($books->isEmpty())
                    <div class="text-center py-16 text-slate-400">
                        <svg class="w-12 h-12 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <p class="font-medium">No books assigned to this department yet.</p>
                    </div>
                @else
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-sm border-b border-slate-100">
                                <th class="py-3 px-6 font-semibold">Title</th>
                                <th class="py-3 px-6 font-semibold">Author</th>
                                <th class="py-3 px-6 font-semibold">Category</th>
                                <th class="py-3 px-6 font-semibold text-center">Available</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                                <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition">
                                    <td class="py-3 px-6 font-medium text-slate-900">{{ $book->title }}</td>
                                    <td class="py-3 px-6 text-slate-500 text-sm">{{ $book->author }}</td>
                                    <td class="py-3 px-6 text-slate-500 text-sm">{{ $book->category ?: '—' }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <span class="font-bold {{ $book->available_quantity > 0 ? 'text-emerald-600' : 'text-rose-500' }}">
                                            {{ $book->available_quantity }}/{{ $book->quantity }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-6 py-4">
                        {{ $books->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
