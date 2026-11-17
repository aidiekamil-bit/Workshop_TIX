@extends('layouts.app')

@section('title', $workshop->title . ' - WorkshopTix')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Tombol Kembali -->
    <a href="{{ route('workshops.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-900 mb-6 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Daftar Workshop
    </a>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-100 overflow-hidden">
        <!-- Banner Atas -->
        <div class="h-64 sm:h-80 bg-slate-900 relative">
            <img src="{{ $workshop->image ? asset('storage/' . $workshop->image) : 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $workshop->title }}" class="w-full h-full object-cover opacity-90">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/30 to-transparent"></div>
            
            <div class="absolute bottom-6 left-6 right-6 sm:left-10 sm:right-10 text-white flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    @if($workshop->category)
                        <span class="inline-flex items-center gap-1.5 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2 shadow-sm">
                            {{ $workshop->category->name }}
                        </span>
                    @endif
                    <span class="inline-flex items-center gap-1.5 bg-emerald-500 text-slate-950 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-950 animate-pulse"></span>
                        Sisa Kuota: {{ $workshop->quota }} Kursi
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold mt-3 tracking-tight text-white">
                        {{ $workshop->title }}
                    </h1>
                </div>
            </div>
        </div>

        <!-- Konten Utama (Grid 3 Kolom: 2 untuk Deskripsi, 1 untuk Card Aksi) -->
        <div class="p-6 sm:p-10 grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Kolom Kiri: Deskripsi Detail -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-slate-50/50 rounded-2xl p-6 border border-slate-100">
                    <h2 class="text-lg font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tentang Workshop Ini
                    </h2>
                    <p class="text-slate-600 leading-relaxed whitespace-pre-line text-sm sm:text-base">
                        {{ $workshop->description }}
                    </p>
                </div>
            </div>

            <!-- Kolom Kanan: Kartu Ringkasan & Tombol Aksi (Sticky agar tetap di tempat saat di-scroll) -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-lg shadow-slate-100/50 space-y-5 lg:sticky lg:top-6">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Biaya Pendaftaran</span>
                    <div class="text-3xl font-black text-slate-900 mt-1">
                        Rp {{ number_format($workshop->price, 0, ',', '.') }}
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-4 space-y-3.5 text-sm">
                    <!-- Pemateri -->
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Pemateri
                        </span>
                        <span class="font-bold text-slate-900 text-right">{{ $workshop->speaker }}</span>
                    </div>
                    <!-- Tanggal -->
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Tanggal
                        </span>
                        <span class="font-bold text-slate-900">{{ date('d M Y', strtotime($workshop->date)) }}</span>
                    </div>
                    <!-- Waktu -->
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Waktu
                        </span>
                        <span class="font-bold text-slate-900">{{ date('H:i', strtotime($workshop->time)) }} WIB</span>
                    </div>
                </div>

                <!-- Notifikasi Sukses/Error -->
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-xs font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl text-xs font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="pt-2">
                    @auth
                        @php
                            $hasRegistered = \App\Models\Registration::where('user_id', auth()->id())->where('workshop_id', $workshop->id)->first();
                        @endphp

                        @if($hasRegistered)
                            <!-- Jika sudah terdaftar -->
                            <div class="bg-emerald-50/80 border border-emerald-200/80 rounded-2xl p-4 text-center space-y-2.5">
                                <span class="inline-block text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-md uppercase tracking-wider">
                                    Status Anda
                                </span>
                                <p class="text-xs font-bold text-emerald-900">Anda sudah terdaftar di workshop ini</p>
                                <div class="bg-white px-3 py-2 rounded-xl border border-emerald-100 font-mono text-xs font-bold text-slate-700 shadow-sm">
                                    {{ $hasRegistered->ticket_code }}
                                </div>
                                <a href="{{ route('registrations.index') }}" class="block w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition text-center shadow-md">
                                    Lihat di Tiket Saya
                                </a>
                            </div>
                        @elseif($workshop->quota <= 0)
                            <!-- Jika kuota habis -->
                            <div class="bg-slate-100 border border-slate-200 rounded-2xl p-4 text-center">
                                <p class="text-sm font-bold text-slate-600">Mohon Maaf, Kuota Penuh</p>
                                <p class="text-xs text-slate-400 mt-1">Kursi untuk workshop ini sudah habis.</p>
                            </div>
                        @else
                            <!-- Form Daftar -->
                            <form action="{{ route('workshops.register', $workshop->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-emerald-500/20 transition flex items-center justify-center gap-2">
                                    <span>Daftar & Lanjut Pembayaran</span>
                                </button>
                            </form>
                        @endif
                    @else
                        <!-- Belum Login -->
                        <a href="{{ route('login') }}" class="block w-full text-center bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg transition duration-200 text-sm">
                            Masuk untuk Mendaftar
                        </a>
                    @endauth
                </div>
            </div>

        </div>
    </div>
</div>
@endsection