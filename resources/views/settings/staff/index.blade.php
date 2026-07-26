<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Public Staff Profiles') }}
            </h2>
            <a href="{{ route('settings.staff.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-bold hover:bg-indigo-700 transition">
                + Add Staff Member
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

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-semibold">Staff Member</th>
                            <th class="px-6 py-4 font-semibold">Title</th>
                            <th class="px-6 py-4 font-semibold">Order</th>
                            <th class="px-6 py-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($staff as $member)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-100 flex-shrink-0">
                                            @if($member->image_path)
                                                <img src="{{ asset('storage/' . $member->image_path) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900">{{ $member->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $member->phone }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $member->title }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $member->order }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('settings.staff.edit', $member) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold text-sm mr-3">Edit</a>
                                    <form action="{{ route('settings.staff.destroy', $member) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this staff profile?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-900 font-semibold text-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    No staff profiles added yet. Click "Add Staff Member" to begin.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
