@extends('layouts.app')

@section('title', 'Tiket Saya - WorkshopTix')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1 rounded-full uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                Panel Peserta
            </span>
            <h1 class="text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">
                Tiket Saya
            </h1>
            <p class="text-slate-500 text-sm mt-1">
                Daftar workshop IT yang telah kamu daftarkan dan ikuti.
            </p>
        </div>
        <div>
            <a href="{{ route('workshops.index') }}" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm px-5 py-3 rounded-xl shadow-lg shadow-emerald-500/15 transition">
                <span>+ Jelajah Workshop Lain</span>
            </a>
        </div>
    </div>

    <!-- Notifikasi Sukses/Error -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Grid List Tiket Saya -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($registrations as $reg)
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-100 p-6 flex flex-col justify-between transition hover:-translate-y-1">
            <div>
                <!-- Status & Kode Tiket -->
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold px-3 py-1 rounded-lg uppercase border {{ $reg->payment_status == 'paid' ? 'bg-emerald-50 text-emerald-700 border-emerald-200/60' : 'bg-amber-50 text-amber-700 border-amber-200/60' }}">
                        {{ $reg->payment_status }}
                    </span>
                    <span class="text-xs font-mono font-bold bg-slate-100 text-slate-800 px-2.5 py-1 rounded-lg border border-slate-200">
                        {{ $reg->ticket_code }}
                    </span>
                </div>

                <!-- Judul & Deskripsi -->
                <h3 class="text-xl font-extrabold text-slate-900 mb-2 tracking-tight line-clamp-1">
                    {{ $reg->workshop->title }}
                </h3>
                <p class="text-slate-500 text-sm line-clamp-2 mb-6 leading-relaxed">
                    {{ $reg->workshop->description }}
                </p>

                <!-- Informasi Detail (Menggunakan SVG Icon) -->
                <div class="text-xs font-medium text-slate-600 mb-6 space-y-2.5 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <!-- Jadwal -->
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ date('d M Y', strtotime($reg->workshop->date)) }} <span class="text-slate-900 font-semibold">{{ date('H:i', strtotime($reg->workshop->time)) }} WIB</span></span>
                    </div>
                    <!-- Pemateri -->
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Pemateri: <span class="text-slate-900 font-semibold">{{ $reg->workshop->speaker }}</span></span>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi Bawah -->
            <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
                @if($reg->payment_status == 'paid')
                    <!-- Jika sudah bayar / paid -->
                    <div class="flex items-center justify-between gap-2">
                        <a href="{{ route('tickets.download', $reg->id) }}" target="_blank" class="flex-1 inline-flex items-center justify-center gap-1.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <span>Unduh E-Tiket</span>
                        </a>
                        <a href="{{ route('workshops.show', $reg->workshop->id) }}" class="text-emerald-600 hover:text-emerald-700 font-bold text-xs transition inline-flex items-center gap-1">
                            Detail →
                        </a>
                    </div>
                @else
                   <button type="button" onclick="payAndComplete('{{ $reg->id }}', '{{ $reg->ticket_code }}')" class="w-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs py-2.5 px-4 rounded-xl transition shadow-sm text-center mb-2">
    Bayar Sekarang
</button>
                    <div class="flex justify-between items-center text-xs px-1">
                        <span class="text-amber-600 font-medium">Menunggu pembayaran</span>
                        <a href="{{ route('workshops.show', $reg->workshop->id) }}" class="text-emerald-600 hover:text-emerald-700 font-bold transition inline-flex items-center gap-1">
                            Detail →
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @empty
        <!-- Empty State (Jika belum punya tiket) -->
        <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-100">
            <div class="max-w-md mx-auto px-4">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center mx-auto mb-4 border border-emerald-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Kamu belum memiliki tiket</h3>
                <p class="text-slate-400 text-sm mb-6">Yuk, jelajahi berbagai workshop menarik dan daftarkan dirimu sekarang!</p>
                <a href="{{ route('workshops.index') }}" class="inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm px-6 py-3 rounded-xl shadow-md transition">
                    Cari Workshop Sekarang
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    function payAndComplete(registrationId, ticketCode) {
        // Ambil token baru dulu secara AJAX untuk menghindari error 409 Conflict
        fetch('/payment/renew-token/' + registrationId, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Buka popup Midtrans menggunakan token yang baru
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        updateStatusToPaid(ticketCode);
                    },
                    onPending: function(result) {
                        updateStatusToPaid(ticketCode);
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal!");
                        location.reload();
                    },
                    onClose: function() {
                        // Begitu popup ditutup setelah simulasi bayar, update database
                        updateStatusToPaid(ticketCode);
                    }
                });
            } else {
                alert("Gagal memuat token pembayaran: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Terjadi kesalahan koneksi.");
        });
    }

    function updateStatusToPaid(ticketCode) {
        fetch('/payment/success-update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ order_id: ticketCode })
        })
        .then(response => response.json())
        .then(data => {
            location.reload(); // Otomatis refresh halaman menjadi PAID & hijau
        })
        .catch(error => {
            console.error('Error:', error);
            location.reload();
        });
    }
</script>
@endsection