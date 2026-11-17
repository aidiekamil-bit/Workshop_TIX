@extends('layouts.app')

@section('title', 'Panel Panitia - WorkshopTix')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header Panel -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1 rounded-full uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                Panel Panitia (Admin)
            </span>
            <h1 class="text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">
                Kelola Daftar Workshop
            </h1>
            <p class="text-slate-500 text-sm mt-1">
                Tambah, pantau, dan kelola semua jadwal workshop IT yang tersedia.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Tombol Kelola Kategori (Tambahan Navigasi Master Data) -->
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-3 rounded-xl transition text-sm">
                Kelola Kategori
            </a>
            <a href="{{ route('admin.workshops.create') }}" class="inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold px-5 py-3 rounded-xl shadow-lg shadow-emerald-500/15 transition text-sm">
                <span>+ Tambah Workshop Baru</span>
            </a>
        </div>
    </div>

    <!-- Kartu Statistik Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Workshop -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Workshop</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $totalWorkshops }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        
        <!-- Total Pendaftar -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pendaftar</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $totalRegistrations }} Peserta</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Estimasi Pendapatan -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Estimasi Pendapatan</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Toolbar: Search Bar -->
    <div class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-sm mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.workshops.index') }}" method="GET" class="w-full md:w-96 flex items-center gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari judul workshop atau pemateri..." 
                class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition">
                Cari
            </button>
            @if(isset($search))
                <a href="{{ route('admin.workshops.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline whitespace-nowrap">Reset</a>
            @endif
        </form>
        <div class="text-xs text-slate-400 px-2">
            Menampilkan data workshop aktif
        </div>
    </div>

    <!-- Tabel Data Workshop -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-4 px-6">Foto</th>
                        <th class="py-4 px-6">Workshop</th>
                        <th class="py-4 px-6">Kategori</th> <!-- Kolom Baru -->
                        <th class="py-4 px-6">Pemateri</th>
                        <th class="py-4 px-6">Jadwal</th>
                        <th class="py-4 px-6">Harga</th>
                        <th class="py-4 px-6">Pendaftar</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600 align-middle">
                    @forelse($workshops as $workshop)
                    <tr class="hover:bg-slate-50/50 transition">
                        <!-- Kolom Foto -->
                        <td class="py-4 px-6 whitespace-nowrap">
                            @if($workshop->image)
                                <img src="{{ asset('storage/' . $workshop->image) }}" alt="Banner" class="w-16 h-11 object-cover rounded-xl border border-slate-200 shadow-sm">
                            @else
                                <div class="w-16 h-11 bg-slate-100 rounded-xl flex items-center justify-center text-[10px] text-slate-400 font-bold uppercase tracking-wider border border-slate-200">
                                    No Img
                                </div>
                            @endif
                        </td>

                        <!-- Judul Workshop & Deskripsi Singkat -->
                        <td class="py-4 px-6 max-w-[220px]">
                            <div class="font-bold text-slate-900 line-clamp-1 leading-snug">{{ $workshop->title }}</div>
                            <div class="truncate text-xs text-slate-400 mt-0.5" title="{{ $workshop->description }}">
                                {{ $workshop->description }}
                            </div>
                        </td>

                        <!-- Kolom Kategori (Baru) -->
                        <td class="py-4 px-6 whitespace-nowrap">
                            @if($workshop->category)
                                <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold inline-block border border-indigo-200/60">
                                    {{ $workshop->category->name }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400 italic">Tanpa Kategori</span>
                            @endif
                        </td>

                        <!-- Pemateri -->
                        <td class="py-4 px-6 whitespace-nowrap font-medium text-slate-700">
                            {{ $workshop->speaker }}
                        </td>

                        <!-- Jadwal -->
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="text-slate-900 font-semibold">{{ date('d M Y', strtotime($workshop->date)) }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">{{ date('H:i', strtotime($workshop->time)) }} WIB</div>
                        </td>

                        <!-- Harga -->
                        <td class="py-4 px-6 whitespace-nowrap font-bold text-slate-900">
                            Rp {{ number_format($workshop->price, 0, ',', '.') }}
                        </td>

                        <!-- Pendaftar / Kuota -->
                        <td class="py-4 px-6 whitespace-nowrap">
                            <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-lg text-xs font-bold inline-block border border-emerald-200/60">
                                {{ $workshop->registrations->count() }} / {{ $workshop->quota }} Kursi
                            </span>
                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-6 text-center whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="{{ route('admin.workshops.edit', $workshop->id) }}" class="inline-flex items-center justify-center text-emerald-700 hover:text-emerald-900 font-bold text-xs bg-emerald-50 hover:bg-emerald-100 px-3 py-2 rounded-xl transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.workshops.destroy', $workshop->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus workshop ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center text-rose-600 hover:text-rose-800 font-bold text-xs bg-rose-50 hover:bg-rose-100 px-3 py-2 rounded-xl transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-12 text-slate-400">
                            @if(isset($search))
                                Tidak ditemukan workshop dengan kata kunci "<span class="font-semibold text-slate-600">{{ $search }}</span>".
                            @else
                                Belum ada data workshop yang dibuat. Silakan tambah baru.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        @if($workshops->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $workshops->links() }}
            </div>
        @endif
    </div>
</div>
@endsection