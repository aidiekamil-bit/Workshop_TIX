@extends('layouts.app')

@section('title', 'Checkout Pembayaran - WorkshopTix')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl border border-slate-200/85 shadow-xl p-8">
        <!-- Header / Judul -->
        <div class="text-center mb-8">
            <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">Menunggu Pembayaran</span>
            <h2 class="text-2xl font-extrabold text-slate-900 mt-3">Detail Pembayaran Workshop</h2>
            <p class="text-slate-500 text-sm mt-1">Periksa kembali detail pesanan kamu sebelum melakukan pembayaran.</p>
        </div>

        <!-- Detail Informasi Pesanan -->
        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 mb-8 space-y-4">
            <div class="flex justify-between items-center border-b border-slate-200/60 pb-3">
                <span class="text-slate-500 text-sm">Kode Tiket</span>
                <span class="font-mono font-bold text-slate-800 bg-slate-200/60 px-3 py-1 rounded-lg text-sm">{{ $registration->ticket_code }}</span>
            </div>
            <div class="flex justify-between items-center border-b border-slate-200/60 pb-3">
                <span class="text-slate-500 text-sm">Nama Workshop</span>
                <span class="font-semibold text-slate-900 text-right">{{ $workshop->title }}</span>
            </div>
            <div class="flex justify-between items-center border-b border-slate-200/60 pb-3">
                <span class="text-slate-500 text-sm">Pemateri</span>
                <span class="font-medium text-slate-700">{{ $workshop->speaker ?? 'Profesional' }}</span>
            </div>
            <div class="flex justify-between items-center pt-1">
                <span class="text-slate-700 font-bold">Total Harga</span>
                <span class="text-2xl font-extrabold text-emerald-600">Rp {{ number_format($workshop->price, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex flex-col gap-3">
            <button id="pay-button" class="w-full bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-emerald-500/20 transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Bayar Sekarang via Midtrans
            </button>
            
            <a href="{{ route('dashboard') }}" class="w-full text-center text-slate-500 hover:text-slate-800 text-sm font-medium py-2 transition">
                ← Kembali ke Dashboard (Bayar Nanti)
            </a>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    // Pop-up Midtrans HANYA akan muncul saat tombol 'Bayar Sekarang' diklik oleh user
    document.getElementById('pay-button').onclick = function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = "{{ route('payment.finish') }}?order_id=" + result.order_id;
            },
            onPending: function(result) {
                window.location.href = "{{ route('dashboard') }}";
            },
            onError: function(result) {
                alert("Pembayaran gagal!");
                window.location.href = "{{ route('dashboard') }}";
            },
            onClose: function() {
                // Kalau user menutup pop-up tanpa bayar, arahkan ke dashboard dengan status tetap pending
                window.location.href = "{{ route('dashboard') }}";
            }
        });
    };
</script>
@endsection