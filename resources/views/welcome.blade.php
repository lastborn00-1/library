@extends('layouts.public')

@section('content')
<div class="relative bg-slate-900 overflow-hidden min-h-screen flex items-center justify-center" 
     style="z-index: 1; isolation: auto;"
     x-data="{
        active: 0,
        images: [
            '{{ asset('background.jpg') }}',
            '{{ asset('bg1.PNG') }}',
            '{{ asset('bg2.PNG') }}',
            '{{ asset('bg3.PNG') }}',
            '{{ asset('bg4.PNG') }}'
        ],
        init() {
            setInterval(() => {
                this.active = (this.active + 1) % this.images.length;
            }, 5000);
        }
     }">
    <!-- Background Slideshow Images -->
    <template x-for="(img, idx) in images" :key="idx">
        <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 ease-in-out"
             :style="'background-image: url(' + img + '); z-index: 0;'"
             :class="active === idx ? 'opacity-95 scale-100' : 'opacity-0 scale-105 pointer-events-none'"></div>
    </template>
    
    <!-- Dark Gradient Overlay for text contrast -->
    <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900/40 to-slate-900/85" style="z-index: 1;"></div>
    
    <!-- Content Container -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-44 md:py-56 text-center z-10">
        <h1 class="text-5xl sm:text-7xl md:text-8xl lg:text-9xl font-black text-white tracking-tight mb-8 drop-shadow-2xl leading-none">
            Explore Our Library
        </h1>
        <p class="mt-8 text-2xl sm:text-3xl md:text-4xl text-slate-100 font-semibold max-w-5xl mx-auto drop-shadow-2xl leading-relaxed">
            Welcome to the Kwara State College of Health Technology Library. Discover academic resources, research materials, and our extensive catalog.
        </p>

        <!-- Slide Indicators -->
        <div class="mt-16 flex justify-center items-center space-x-4">
            <template x-for="(img, idx) in images" :key="'dot-' + idx">
                <button @click="active = idx" 
                        class="h-4 rounded-full transition-all duration-300 focus:outline-none shadow-xl"
                        :class="active === idx ? 'w-14 bg-emerald-500' : 'w-4 bg-white/70 hover:bg-white'"
                        :aria-label="'Go to slide ' + (idx + 1)"></button>
            </template>
        </div>
    </div>
</div>

<!-- Library Hours & Services -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- Opening Hours -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 h-full">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-6">Library Hours</h3>
                
                <ul class="space-y-4 text-slate-600">
                    <li class="flex justify-between items-center border-b border-slate-50 pb-2">
                        <span class="font-medium">Monday - Friday</span>
                        <span class="text-indigo-600 font-semibold">8:00 AM - 6:00 PM</span>
                    </li>
                    <li class="flex justify-between items-center border-b border-slate-50 pb-2">
                        <span class="font-medium">Saturday</span>
                        <span class="text-indigo-600 font-semibold">9:00 AM - 2:00 PM</span>
                    </li>
                    <li class="flex justify-between items-center pb-2">
                        <span class="font-medium text-rose-500">Sunday & Public Holidays</span>
                        <span class="text-slate-400 font-semibold">Closed</span>
                    </li>
                </ul>
                
                <div class="mt-8 p-4 bg-amber-50 rounded-lg border border-amber-100">
                    <p class="text-sm text-amber-800 flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Hours may vary during exam periods and school holidays. Check notice boards for updates.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Our Services -->
        <div class="lg:col-span-2">
            <h2 class="text-3xl font-bold text-slate-900 mb-8">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Service 1 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                    <h4 class="text-lg font-bold text-indigo-900 mb-2">Reference Services</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Personalized assistance in locating information, using library resources, and conducting academic research effectively.</p>
                </div>
                <!-- Service 2 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                    <h3 class="mt-4 text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition">Circulation Services</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Registration of new users and charging, discharging, of library materials. We ensure seamless access to our vast physical collections.</p>
                </div>
                <!-- Service 3 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                    <h3 class="mt-4 text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition">E-Library & Internet Access</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Access to open and subscribed database and scholarly academic resources and journals.</p>
                </div>
                <!-- Service 4 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                    <h4 class="text-lg font-bold text-indigo-900 mb-2">Institutional Repository</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Digital archiving and access to student research projects and institutional publications.</p>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
