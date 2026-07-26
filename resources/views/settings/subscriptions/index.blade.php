<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Manage Subscribed E-Resources') }}
            </h2>
            <a href="{{ route('settings.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-300 transition">
                &larr; Back to Settings
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Add Subscription Form -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                <h3 class="text-lg font-bold text-slate-900 mb-6">Add New Subscribed Resource</h3>
                
                <form action="{{ route('settings.subscriptions.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Resource Title / Name *</label>
                            <input type="text" name="title" required placeholder="e.g. Research4Life, Hinari, ScienceDirect" value="{{ old('title') }}"
                                   class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('title') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Access Link / URL *</label>
                            <input type="url" name="url" required placeholder="https://www.research4life.org" value="{{ old('url') }}"
                                   class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('url') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Description (Optional)</label>
                        <textarea name="description" rows="2" placeholder="Brief description of the subscribed database or access details..."
                                  class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('description') }}</textarea>
                        @error('description') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <button type="submit" class="px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition">
                            Save Subscribed Resource
                        </button>
                    </div>
                </form>
            </div>

            <!-- Existing Subscriptions Table -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900">Current Subscribed Resources ({{ $subscriptions->count() }})</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-700 font-semibold uppercase text-xs">
                            <tr>
                                <th class="px-6 py-4">Title</th>
                                <th class="px-6 py-4">URL</th>
                                <th class="px-6 py-4">Description</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($subscriptions as $sub)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $sub->title }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ $sub->url }}" target="_blank" class="text-indigo-600 hover:underline flex items-center gap-1 font-medium">
                                            {{ $sub->url }}
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 max-w-xs truncate">{{ $sub->description ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('settings.subscriptions.destroy', $sub) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this subscription link?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-rose-50 text-rose-600 rounded-lg text-xs font-bold hover:bg-rose-100 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                        No subscribed resources added yet.
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
