@extends('layouts.public')

@section('content')
<style>
@keyframes heroDropDown {
    0% {
        opacity: 0;
        transform: translateY(-40px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
.hero-drop-1 {
    animation: heroDropDown 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
.hero-drop-2 {
    animation: heroDropDown 1s cubic-bezier(0.16, 1, 0.3, 1) 0.15s forwards;
    opacity: 0;
}
.hero-drop-3 {
    animation: heroDropDown 1s cubic-bezier(0.16, 1, 0.3, 1) 0.3s forwards;
    opacity: 0;
}
.hero-drop-4 {
    animation: heroDropDown 1s cubic-bezier(0.16, 1, 0.3, 1) 0.45s forwards;
    opacity: 0;
}
</style>

<div class="relative bg-slate-950 overflow-hidden min-h-screen flex items-center justify-center" 
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
            }, 10000);
        }
     }">
     
    <!-- Background Sliding Track (Continuous Right-to-Left Slider) -->
    <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none" style="z-index: 0;">
        <div class="flex h-full"
             :style="'width: ' + (images.length * 100) + '%; transform: translateX(-' + (active * (100 / images.length)) + '%); transition: transform 2.5s cubic-bezier(0.25, 1, 0.5, 1);'">
            <template x-for="(img, idx) in images" :key="idx">
                <div class="h-full bg-cover bg-center flex-shrink-0"
                     :style="'width: ' + (100 / images.length) + '%; background-image: url(' + img + ');'">
                </div>
            </template>
        </div>
    </div>
    
    <!-- Subtle Contrast Overlay to Keep Background Vibrant & Bright -->
    <div class="absolute inset-0 bg-black/25" style="z-index: 1;"></div>
    
    <!-- Content Container -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 text-center z-10">
        
        <!-- Welcome Badge -->
        <div class="hero-drop-1 inline-flex items-center gap-3.5 px-7 py-2.5 rounded-full bg-white/10 backdrop-blur-md border border-white/80 text-white text-sm sm:text-base md:text-lg font-bold tracking-wider uppercase mb-6 shadow-sm">
            <span class="w-3.5 h-3.5 rounded-full bg-white"></span>
            Kwara State College of Health Technology
        </div>

        <!-- Hero Headline -->
        <h1 class="hero-drop-2 text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white uppercase tracking-tight mb-6 leading-tight"
            style="text-shadow: 0 2px 8px rgba(0,0,0,0.4);">
            Explore Our Library
        </h1>

        <!-- Hero Subtitle (+5% size increase, natural text shadow) -->
        <p class="hero-drop-3 mt-4 text-xl sm:text-[23px] md:text-[28px] text-white font-medium max-w-4xl mx-auto leading-relaxed"
           style="text-shadow: 0 1px 5px rgba(0,0,0,0.4);">
            Welcome to the Kwara State College of Health Technology Library. Discover academic resources, research materials, and our extensive catalog.
        </p>

        <!-- CTA Buttons (Exact match to screenshot) -->
        <div class="hero-drop-4 mt-10 flex flex-wrap justify-center items-center gap-4">
            <a href="{{ url('/e-resources') }}" class="px-7 py-3.5 bg-[#00a86b] hover:bg-[#008f5b] text-white font-bold text-base md:text-lg rounded-xl shadow-lg transition transform hover:scale-105 flex items-center gap-2.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Explore E-Resources
            </a>
            <a href="{{ route('repository.home') }}" class="px-7 py-3.5 bg-transparent border border-white/80 hover:bg-white/10 text-white font-bold text-base md:text-lg rounded-xl shadow-lg transition transform hover:scale-105 flex items-center gap-2.5">
                Institutional Repository &rarr;
            </a>
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
