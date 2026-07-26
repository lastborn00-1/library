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
                <!-- Student Self-Registration Status Control -->
                @php
                    $regEnabled = ($settings['student_registration_enabled'] ?? '1') !== '0';
                @endphp
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 hover:shadow-md transition col-span-1 md:col-span-2 border-l-8 {{ $regEnabled ? 'border-l-emerald-500' : 'border-l-rose-500' }}">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-xl font-bold text-slate-900">Student Self-Registration Portal</h3>
                                <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider {{ $regEnabled ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    STATUS: {{ $regEnabled ? 'OPEN / ACTIVE' : 'CLOSED / DISABLED' }}
                                </span>
                            </div>
                            <p class="text-slate-500 text-sm">
                                Control whether new students can create their own library account online. When closed, accessing the registration link shows a "Registration Closed" notice.
                            </p>
                        </div>
                        
                        <form action="{{ route('settings.toggle-registration') }}" method="POST" class="flex items-center gap-3">
                            @csrf
                            <input type="hidden" name="student_registration_enabled" value="{{ $regEnabled ? '0' : '1' }}">
                            @if($regEnabled)
                                <button type="submit" style="display:inline-block; padding: 12px 24px; background-color: #e11d48; color: #ffffff; font-weight: 800; border-radius: 12px; text-decoration: none; font-size: 14px;" onmouseover="this.style.backgroundColor='#be123c'" onmouseout="this.style.backgroundColor='#e11d48'">
                                    Switch OFF (Close Registration)
                                </button>
                            @else
                                <button type="submit" style="display:inline-block; padding: 12px 24px; background-color: #059669; color: #ffffff; font-weight: 800; border-radius: 12px; text-decoration: none; font-size: 14px;" onmouseover="this.style.backgroundColor='#047857'" onmouseout="this.style.backgroundColor='#059669'">
                                    Switch ON (Open Registration)
                                </button>
                            @endif
                        </form>
                    </div>
                </div>

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

                <!-- Departmental E-Resources & Downloads Management -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Departmental E-Resources & Downloads</h3>
                    <p class="text-slate-500 text-sm mb-6">Upload and manage learning materials, lecture manuals, and files for each department.</p>
                    <a href="{{ route('settings.departmental-materials.index') }}" style="display:inline-block; padding: 12px 24px; background-color: #ea580c; color: #ffffff; font-weight: 800; border-radius: 12px; text-decoration: none; font-size: 14px;" onmouseover="this.style.backgroundColor='#c2410c'" onmouseout="this.style.backgroundColor='#ea580c'">
                        Manage Department Downloads
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
                    <h3 class="text-xl font-bold text-slate-800 mb-2">E-Resources (Open Source)</h3>
                    <p class="text-slate-500 text-sm mb-6">Manage external open access links and open source databases.</p>
                    <a href="{{ route('settings.eresources.index') }}" style="display:inline-block; padding: 12px 28px; background-color: #d97706; color: #ffffff; font-weight: 800; border-radius: 12px; text-decoration: none; font-size: 15px; letter-spacing: 0.01em;" onmouseover="this.style.backgroundColor='#b45309'" onmouseout="this.style.backgroundColor='#d97706'">
                        Manage E-Resources
                    </a>
                </div>

                <!-- Subscribed E-Resources Management -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Subscribed E-Resources</h3>
                    <p class="text-slate-500 text-sm mb-6">Manage paid subscriptions links (e.g. Research4Life, Hinari, ScienceDirect) for dropdown menu.</p>
                    <a href="{{ route('settings.subscriptions.index') }}" style="display:inline-block; padding: 12px 28px; background-color: #0d9488; color: #ffffff; font-weight: 800; border-radius: 12px; text-decoration: none; font-size: 15px; letter-spacing: 0.01em;" onmouseover="this.style.backgroundColor='#0f766e'" onmouseout="this.style.backgroundColor='#0d9488'">
                        Manage Subscriptions
                    </a>
                </div>

                <!-- Past Examination Questions Management -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-cyan-50 text-cyan-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Past Examination Questions</h3>
                    <p class="text-slate-500 text-sm mb-6">Upload past questions in PDF or image format (JPG, PNG) for student access.</p>
                    <a href="{{ route('settings.past-questions.index') }}" style="display:inline-block; padding: 12px 28px; background-color: #0891b2; color: #ffffff; font-weight: 800; border-radius: 12px; text-decoration: none; font-size: 15px; letter-spacing: 0.01em;" onmouseover="this.style.backgroundColor='#0e7490'" onmouseout="this.style.backgroundColor='#0891b2'">
                        Manage Past Questions
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
