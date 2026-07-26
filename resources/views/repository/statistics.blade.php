<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Repository Statistics') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Summary Cards -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Total Uploads</p>
                    <h3 class="text-4xl font-black text-indigo-600 mt-2">{{ $stats['total_projects'] ?? 0 }}</h3>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Approved</p>
                    <h3 class="text-4xl font-black text-emerald-600 mt-2">{{ $stats['approved_projects'] ?? 0 }}</h3>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Pending</p>
                    <h3 class="text-4xl font-black text-amber-600 mt-2">{{ $stats['pending_projects'] ?? 0 }}</h3>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Storage Used</p>
                    <h3 class="text-4xl font-black text-slate-800 mt-2">{{ $stats['storage_used'] ?? '0 B' }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-6 border-b pb-2">Projects by Department</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($stats['by_department'] ?? [] as $dept)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex justify-between items-center">
                            <span class="font-bold text-slate-700">{{ $dept->name }}</span>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 font-black rounded-lg">{{ $dept->projects_count }}</span>
                        </div>
                    @empty
                        <p class="text-slate-500 italic">No departmental data available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
