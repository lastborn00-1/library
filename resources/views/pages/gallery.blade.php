@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
        <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
        <h1 class="text-3xl font-extrabold text-slate-900 mb-4">Gallery</h1>
        <p class="text-lg text-slate-500 max-w-2xl mx-auto mb-12">
            A visual showcase of the Library facilities, events, and activities.
        </p>
        
        @if(isset($images) && $images->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($images as $img)
                    <div class="relative group rounded-2xl overflow-hidden shadow-sm border border-slate-100 bg-slate-50 aspect-square">
                        <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $img->caption }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @if($img->caption)
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                                <p class="text-white text-sm font-medium p-4 w-full text-left truncate">{{ $img->caption }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-12 text-slate-500 bg-slate-50 rounded-2xl border border-slate-100 border-dashed">
                Gallery is currently being updated. Check back soon!
            </div>
        @endif
    </div>
</div>
@endsection
