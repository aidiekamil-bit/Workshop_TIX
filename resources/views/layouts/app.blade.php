<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WorkshopTix - Tiket Digital Workshop IT')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

   <!-- Navbar Minimalis Modern (Nuansa Hitam & Hijau Emerald) -->
   <!-- Navbar Minimalis Modern (Tanpa Kotak Logo) -->
    <header class="sticky top-0 z-50 bg-slate-950/90 backdrop-blur-md border-b border-slate-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand / Nama Saja -->
            <a href="/" class="group">
                <span class="text-xl font-black tracking-tight text-white">WORKSHOP<span class="text-emerald-400">TIX</span></span>
            </a>

           <nav class="hidden md:flex items-center gap-8 text-sm font-semibold">
    <!-- Menu Jelajah Workshop -->
    <a href="{{ route('workshops.index') }}" 
       class="{{ request()->routeIs('workshops.index') ? 'text-emerald-400 border-b-2 border-emerald-400 pb-1' : 'text-slate-300 hover:text-emerald-400' }} transition">
        Jelajahi Workshop
    </a>

    @auth
        @if(Auth::user()->role !== 'admin')
            <!-- Menu Tiket Saya -->
            <a href="{{ route('registrations.index') }}" 
               class="{{ request()->routeIs('registrations.*') ? 'text-emerald-400 border-b-2 border-emerald-400 pb-1' : 'text-slate-300 hover:text-emerald-400' }} transition">
                Tiket Saya
            </a>
        @else
            <!-- Menu Kelola Workshop (Admin) -->
            <a href="{{ route('admin.workshops.index') }}" 
               class="{{ request()->routeIs('admin.workshops.*') ? 'text-emerald-400 border-b-2 border-emerald-400 pb-1' : 'text-slate-300 hover:text-emerald-400' }} transition">
                Kelola Workshop
            </a>
        @endif
    @endauth
</nav>

            <div class="flex items-center gap-4">
                @auth
                    <span class="text-sm font-medium text-slate-300 hidden sm:inline">
                        Halo, <strong class="text-white">{{ Auth::user()->name }}</strong>
                    </span>
                    
                    @if(Auth::user()->role === 'admin')
                       <a href="{{ route('admin.workshops.index') }}" class="text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1.5 rounded-lg hover:bg-emerald-500/20 transition">
                            Panel Panitia
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-semibold text-rose-400 hover:text-rose-300 px-3 py-2 transition">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 hover:text-emerald-400 px-4 py-2 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold bg-emerald-500 text-slate-950 px-5 py-2.5 rounded-xl shadow-md hover:bg-emerald-400 transition font-bold">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="mb-auto">
        @yield('content')
    </main>

    <!-- Footer Clean Gelap -->
    <footer class="bg-slate-950 text-slate-400 border-t border-slate-800 mt-20 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm">
            © 2026 WorkshopTix. M.Aidiel Kamil XI-2
        </div>
    </footer>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
</body>
</html>