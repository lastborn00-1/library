<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- System Admin - System Users -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">System Admin Accounts</h3>
                    <p class="text-slate-500 text-sm mb-6">Manage login accounts for Librarians and Administrators.</p>
                    <a href="{{ route('librarians.index') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition">
                        Manage Accounts
                    </a>
                </div>

                <!-- Staff Profiles (Public Facing) -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Public Staff Profiles</h3>
                    <p class="text-slate-500 text-sm mb-6">Manage the staff profiles and images displayed on the public library website.</p>
                    <a href="{{ route('settings.staff.index') }}" class="inline-block px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition">
                        Manage Staff Profiles
                    </a>
                </div>

                <!-- Gallery Management -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Gallery Images</h3>
                    <p class="text-slate-500 text-sm mb-6">Upload and manage pictures shown on the public gallery page.</p>
                    <a href="{{ route('settings.gallery.index') }}" class="inline-block px-6 py-3 bg-rose-600 text-white font-bold rounded-xl hover:bg-rose-700 transition">
                        Manage Gallery
                    </a>
                </div>

                <!-- E-Resources Management -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">E-Resources</h3>
                    <p class="text-slate-500 text-sm mb-6">Manage external links, databases, and uploaded files for teaching and research.</p>
                    <a href="{{ route('settings.eresources.index') }}" style="display:inline-block; padding: 12px 28px; background-color: #d97706; color: #ffffff; font-weight: 800; border-radius: 12px; text-decoration: none; font-size: 15px; letter-spacing: 0.01em;" onmouseover="this.style.backgroundColor='#b45309'" onmouseout="this.style.backgroundColor='#d97706'">
                        Manage E-Resources
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
