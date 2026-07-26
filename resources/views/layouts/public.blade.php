<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'KWCHT Library') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Green hover for dropdown items - needed because Tailwind JIT 
           can't compile dynamic hover classes in blade conditionals */
        .nav-dropdown-item:hover {
            background-color: #f0fdf4 !important; /* emerald-50 */
            color: #15803d !important;             /* emerald-700 */
        }
        .nav-dropdown-btn:hover {
            background-color: #f0fdf4 !important;
            color: #15803d !important;
        }
    </style>
</head>
<body class="antialiased bg-gray-50 text-slate-800 flex flex-col min-h-screen">
    
    <!-- Top Bar -->
    <div class="bg-emerald-700 text-white py-2 px-4 md:px-8 text-sm flex flex-col sm:flex-row justify-between items-center z-[100] relative">
        <div class="flex flex-col sm:flex-row items-center space-y-1 sm:space-y-0 sm:space-x-6">
            <span class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +234 811 127 2211</span>
            <span class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> library@offahealthtech.edu.ng</span>
        </div>
        <div class="mt-2 sm:mt-0 flex items-center">
            <a href="https://offahealthtech.edu.ng" target="_blank" class="flex items-center border border-white/30 bg-white/10 px-4 py-1.5 rounded hover:bg-white/20 transition font-medium text-white hover:text-white">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                College Homepage
            </a>
        </div>
    </div>

    <!-- Main Navigation -->
    <header class="bg-white shadow-sm sticky top-0" style="z-index: 9000;" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3">
                        <x-application-logo class="h-12 w-auto text-indigo-600" />
                        <div class="flex items-center leading-none">
                            {{-- KWCHT column: since 1976 above, health first below --}}
                            <div class="flex flex-col items-start">
                                <span class="text-red-600 font-bold leading-none mb-0.5" style="font-size:6px;letter-spacing:0.1em;text-transform:uppercase;">since 1976</span>
                                <span class="text-3xl font-bold tracking-tight text-slate-900 leading-none">KWCHT</span>
                                <span class="text-red-600 font-bold leading-none mt-0.5 self-end" style="font-size:6px;letter-spacing:0.06em;font-style:italic;">health first...</span>
                            </div>
                            {{-- Separator --}}
                            <span class="text-slate-300 font-thin px-2 self-center" style="font-size:2.2rem;line-height:1;">|</span>
                            {{-- LIBRARY --}}
                            <span class="text-3xl font-bold tracking-tight text-indigo-600 leading-none self-center">LIBRARY</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex space-x-1 lg:space-x-4 items-center">
                    <a href="{{ url('/') }}" class="px-3 py-2 rounded-md text-sm font-semibold {{ request()->is('/') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-50' }}">Home</a>
                    <a href="{{ url('/about') }}" class="px-3 py-2 rounded-md text-sm font-semibold {{ request()->is('about') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-50' }}">About</a>
                    
                    <!-- Divisions Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false" @mouseleave="open = false">
                        <button @mouseover="open = true" @click="open = !open"
                            class="nav-dropdown-btn flex items-center px-3 py-2 rounded-md text-sm font-semibold text-slate-700 transition">
                            Divisions
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-transition class="absolute left-0 top-full w-56 rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 z-[9999]" style="display: none;">
                            <div class="py-2" role="menu">
                                <a href="{{ url('/divisions#technical') }}" class="nav-dropdown-item block px-4 py-2.5 text-sm text-slate-700 font-medium">Technical Services</a>
                                <a href="{{ url('/divisions#readers') }}" class="nav-dropdown-item block px-4 py-2.5 text-sm text-slate-700 font-medium">Readers' Services</a>
                                <a href="{{ url('/divisions#electronic') }}" class="nav-dropdown-item block px-4 py-2.5 text-sm text-slate-700 font-medium">Electronic Support Services</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ url('/staff') }}" class="px-3 py-2 rounded-md text-sm font-semibold {{ request()->is('staff') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-50' }}">Staff</a>
                    <a href="{{ url('/login') }}" class="px-3 py-2 rounded-md text-sm font-semibold text-slate-700 hover:text-indigo-600 hover:bg-slate-50">Catalog</a>
                    
                    <!-- Repository Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false" @mouseleave="open = false">
                        <button @mouseover="open = true" @click="open = !open"
                            class="nav-dropdown-btn flex items-center px-3 py-2 rounded-md text-sm font-semibold text-slate-700 transition">
                            Institution Repository
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-transition class="absolute left-0 top-full w-52 rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 z-[9999]" style="display: none;">
                            <div class="py-2" role="menu">
                                <a href="{{ route('repository.home') }}" class="nav-dropdown-item block px-4 py-2.5 text-sm text-slate-700 font-medium">Repository Home</a>
                                <a href="{{ route('repository.home', ['type' => 'staff']) }}" class="nav-dropdown-item block px-4 py-2.5 text-sm text-slate-700 font-medium border-t border-slate-100">Staff Publication</a>
                                <a href="{{ route('repository.home', ['type' => 'student']) }}" class="nav-dropdown-item block px-4 py-2.5 text-sm text-slate-700 font-medium border-t border-slate-100">Student Publication</a>
                                <a href="{{ route('repository.search') }}" class="nav-dropdown-item block px-4 py-2.5 text-sm text-slate-700 font-medium border-t border-slate-100">Search Repository</a>
                                @auth
                                    @if(auth()->user()->role === 'librarian' || auth()->user()->role === 'admin')
                                    <a href="{{ route('repository.dashboard') }}" class="nav-dropdown-item block px-4 py-2.5 text-sm text-slate-700 font-medium border-t border-slate-100">Manage Repository</a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>

                    <a href="{{ url('/e-resources') }}" class="px-3 py-2 rounded-md text-sm font-semibold {{ request()->is('e-resources') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-50' }}">E-Resources</a>
                    <a href="{{ url('/gallery') }}" class="px-3 py-2 rounded-md text-sm font-semibold {{ request()->is('gallery') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-50' }}">Gallery</a>
                    <a href="https://drillbitglobal.com" target="_blank" class="px-3 py-2 rounded-md text-sm font-semibold text-slate-700 hover:text-indigo-600 hover:bg-slate-50">Plagiarism Checker</a>
                </nav>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-bold hover:bg-indigo-100 transition">Dashboard</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-500 hover:text-slate-700 focus:outline-none p-2">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-slate-100 bg-white" style="display: none;">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-slate-50">Home</a>
                <a href="{{ url('/about') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-slate-50">About</a>
                <a href="{{ url('/divisions') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-slate-50">Divisions</a>
                <a href="{{ url('/staff') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-slate-50">Staff</a>
                <a href="{{ url('/login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-slate-50">Catalog</a>
                <a href="{{ route('repository.home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-slate-50">Institution Repository</a>
                <a href="{{ url('/e-resources') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-slate-50">E-Resources</a>
                <a href="{{ url('/gallery') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-slate-50">Gallery</a>
                <a href="https://drillbitglobal.com" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-slate-50">Plagiarism Checker</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 mt-4 text-center rounded-md text-base font-bold text-indigo-700 bg-indigo-50">Dashboard</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-grow flex flex-col">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">KWCHT Library</h3>
                    <p class="text-sm">Empowering students and health professionals with state-of-the-art access to academic resources, research materials, and an extensive digital library catalog.</p>
                </div>
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ url('/books') }}" class="hover:text-white transition">OPAC</a></li>
                        <li><a href="{{ route('repository.home') }}" class="hover:text-white transition">Institutional Repository</a></li>
                        <li><a href="{{ url('/e-resources') }}" class="hover:text-white transition">E-Resources</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-sm">
                        <li>Kwara State College of Health Technology</li>
                        <li>Offa, Kwara State, Nigeria</li>
                        <li>Email: library@kwcht.edu.ng</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-8 pt-8 text-sm text-center">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Built with excellence.
            </div>
        </div>
    </footer>
</body>
</html>
