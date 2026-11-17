@extends('layouts.app')

@section('title', 'Masuk - WorkshopTix')

@section('content')
<div class="min-h-[calc(100vh-160px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
    <div class="max-w-md w-full bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/50 overflow-hidden">
        
        <!-- Header Card Gelap -->
        <div class="bg-slate-950 px-8 py-10 text-center relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-500/20 rounded-full blur-2xl"></div>
            
            <h2 class="text-2xl font-black text-white tracking-tight">WORKSHOP<span class="text-emerald-400">TIX</span></h2>
            <p class="text-xs text-slate-400 mt-1.5">Masuk untuk mengelola tiket dan pendaftaran workshop</p>
        </div>

        <!-- Form Login -->
        <div class="p-8">
            @if ($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-600 text-xs rounded-xl p-4">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="nama@email.com"
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition">
                </div>

                <!-- Password dengan Toggle Mata -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                            placeholder="••••••••"
                            class="w-full px-4 py-3 pr-12 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition">
                        
                        <!-- Tombol Toggle Mata -->
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <!-- Icon Mata Tertutup (Default) -->
                            <svg id="eye-slash" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                            <!-- Icon Mata Terbuka (Hidden by default) -->
                            <svg id="eye-open" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="ml-2 text-xs font-medium text-slate-600">Ingat sesi saya</span>
                    </label>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-slate-950 hover:bg-emerald-600 text-white font-semibold py-3.5 px-4 rounded-xl shadow-md transition-all duration-200">
                    <span>Masuk ke Akun</span>
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>

            <!-- Link ke Register -->
            <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    Belum punya akun peserta? 
                    <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-700 transition">Daftar Sekarang</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Toggle Password -->
<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeSlash = document.getElementById('eye-slash');
    const eyeOpen = document.getElementById('eye-open');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeSlash.classList.add('hidden');
        eyeOpen.classList.remove('hidden');
    } else {
        passwordInput.type = 'password';
        eyeSlash.classList.remove('hidden');
        eyeOpen.classList.add('hidden');
    }
}
</script>
@endsection