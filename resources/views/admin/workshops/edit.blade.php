@extends('layouts.app')

@section('title', 'Edit Workshop - Panel Panitia')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1 rounded-full uppercase tracking-wider">
                Panel Panitia (Admin)
            </span>
            <h1 class="text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">
                Edit Jadwal Workshop
            </h1>
            <p class="text-slate-500 text-sm mt-1">Perbarui informasi, kuota, atau ganti foto banner workshop.</p>
        </div>
        <a href="{{ route('admin.workshops.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-100 p-8">
        @if ($errors->any())
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-600 text-xs rounded-xl p-4">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.workshops.update', $workshop->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Judul -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Workshop</label>
                <input type="text" name="title" value="{{ old('title', $workshop->title) }}" required
                    class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
            </div>
            <!-- Kategori Workshop -->
<div>
    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Workshop</label>
    <select name="category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
        <option value="">-- Pilih Kategori --</option>
        @foreach(\App\Models\Category::all() as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $workshop->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
</div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Lengkap</label>
                <textarea name="description" rows="4" required
                    class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">{{ old('description', $workshop->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pemateri -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Pemateri</label>
                    <input type="text" name="speaker" value="{{ old('speaker', $workshop->speaker) }}" required
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                </div>

                <!-- Harga -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $workshop->price) }}" min="0" required
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Tanggal -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal</label>
                    <input type="date" name="date" value="{{ old('date', $workshop->date) }}" required
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                </div>

                <!-- Jam -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jam (WIB)</label>
                    <input type="time" name="time" value="{{ old('time', $workshop->time) }}" required
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                </div>

                <!-- Kuota -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kuota Peserta</label>
                    <input type="number" name="quota" value="{{ old('quota', $workshop->quota) }}" min="1" required
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                </div>
            </div>

            <!-- Upload / Ganti Foto -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Banner / Foto Workshop</label>
                @if($workshop->image)
                    <div class="mb-3 flex items-center gap-4">
                        <img src="{{ asset('storage/' . $workshop->image) }}" alt="Preview" class="w-24 h-16 object-cover rounded-lg border border-slate-200">
                        <span class="text-xs text-slate-400">Foto saat ini (biarkan kosong jika tidak ingin mengubah)</span>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*"
                    class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">
            </div>

            <!-- Tombol Submit -->
            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.workshops.index') }}" class="px-6 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition">Batal</a>
                <button type="submit" class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold px-6 py-3 rounded-xl shadow-md transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection