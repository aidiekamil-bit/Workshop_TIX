@extends('layouts.app')

@section('content')
<!-- Hero Section (Nuansa Hitam & Aksen Hijau Modern) -->
<div class="relative bg-slate-950 text-white pt-16 pb-14 border-b border-slate-800">
    <!-- Aksen Glow Hijau Halus di Background -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-full overflow-hidden pointer-events-none opacity-20">
        <div class="absolute -top-24 left-1/4 w-96 h-96 bg-emerald-500 rounded-full blur-[120px]"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-mono uppercase tracking-wider bg-emerald-500/10 text-emerald-400 mb-4 border border-emerald-500/20">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>XI RPL • Drill Pra-Sertifikasi</span>
                </div>
                <h1 class="text-4xl sm:text-5xl font-black text-white tracking-tight">
                    WORKSHOP<span class="text-emerald-400">TIX</span>.
                </h1>
                <p class="mt-3 text-slate-400 text-base max-w-xl font-normal leading-relaxed">
                    Platform pendaftaran dan tiket digital workshop IT eksklusif. Pilih sesi, amankan kuotamu, dan tingkatkan portofoliomu.
                </p>
            </div>
            <!-- Quick Stat Badge -->
            <div class="flex items-center gap-3 bg-slate-900 border border-slate-800 px-5 py-3 rounded-2xl shadow-lg">
                <div class="w-10 h-10 rounded-xl bg-emerald-500 text-slate-950 flex items-center justify-center font-black text-lg">
                    {{ $workshops->total() }}
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Sesi</p>
                    <p class="text-sm font-bold text-slate-200">Tersedia untuk Diikuti</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content & Filter Kategori -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-slate-900/5 min-h-screen">
    
    <!-- Filter Kategori Bar -->
    <div class="mb-8 flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mr-2 shrink-0">Filter:</span>
        
        <!-- Tombol "Semua" -->
        <a href="{{ route('workshops.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ !request('category') ? 'bg-slate-950 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80' }}">
            Semua Topik
        </a>

        <!-- List Kategori dari Database -->
        @foreach($categories as $cat)
            <a href="{{ route('workshops.index', ['category' => $cat->id]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ request('category') == $cat->id ? 'bg-emerald-500 text-slate-950 shadow-md shadow-emerald-500/20' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <!-- Grid Workshop -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($workshops as $workshop)
        <div class="bg-white rounded-2xl border border-slate-200 hover:border-emerald-500/50 shadow-sm hover:shadow-xl hover:shadow-emerald-500/5 transition-all duration-300 flex flex-col justify-between overflow-hidden group">
            <div>
                <!-- Thumbnail / Image Container -->
                <div class="h-48 bg-slate-100 relative overflow-hidden">
                    <img src="{{ $workshop->image ? asset('storage/' . $workshop->image) : 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=800&q=80' }}" alt="Workshop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                    
                    
                    <!-- Kuota Badge dengan Aksen Hijau -->
                    <div class="absolute bottom-3 left-3 bg-slate-950/80 backdrop-blur-sm text-white px-2.5 py-1 rounded-md text-xs font-medium border border-slate-800">
                        Sisa Kuota: <span class="font-bold text-emerald-400">{{ $workshop->quota }}</span>
                    </div>
                </div>

                <!-- Body Content -->
                <div class="p-6">
                    <!-- Meta Info: Date & Speaker -->
                    <div class="flex items-center justify-between text-xs text-slate-500 font-medium mb-3 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>{{ date('d M Y', strtotime($workshop->date)) }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 truncate max-w-[120px]">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="truncate">{{ $workshop->speaker }}</span>
                        </div>
                    </div>

                    <!-- Badge Kategori -->
                    <div class="mb-2">
                        @if($workshop->category)
                            <span class="inline-block bg-emerald-50 text-emerald-700 text-[11px] font-bold px-2.5 py-0.5 rounded-full border border-emerald-200/60">
                                {{ $workshop->category->name }}
                            </span>
                        @else
                            <span class="inline-block bg-slate-100 text-slate-400 text-[11px] font-medium px-2.5 py-0.5 rounded-full">
                                Umum
                            </span>
                        @endif
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 tracking-tight mb-2 group-hover:text-emerald-600 transition-colors line-clamp-1">
                        {{ $workshop->title }}
                    </h3>
                    
                    <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">
                        {{ $workshop->description }}
                    </p>
                </div>
            </div>

            <!-- Footer Card / Button Hitam & Hijau -->
            <div class="p-6 pt-0">
                <a href="{{ route('workshops.show', $workshop->id) }}" class="w-full flex items-center justify-center gap-2 bg-slate-950 hover:bg-emerald-600 text-white text-sm font-medium py-3 px-4 rounded-xl transition-all duration-200 shadow-sm">
                    <span>Lihat Detail Sesi</span>
                    <svg class="w-4 h-4 text-emerald-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="col-span-3 text-center py-16 bg-white rounded-2xl border border-dashed border-slate-300 shadow-sm">
            <p class="text-slate-600 font-semibold">Belum ada workshop untuk kategori ini.</p>
            <p class="text-sm text-slate-400 mt-1">Silakan pilih kategori lainnya atau kembali nanti.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="mt-10">
        {{ $workshops->links() }}
    </div>

</div>
@endsection