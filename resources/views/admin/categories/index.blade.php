@extends('layouts.app')

@section('title', 'Manajemen Kategori - WorkshopTix')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Tombol Kembali ke Panel Utama -->
    <a href="{{ route('admin.workshops.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-900 mb-6 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Panel Workshop
    </a>

    <!-- Header & Tombol Tambah -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Master Data Kategori</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola kategori workshop untuk mengelompokkan materi dengan rapi.</p>
        </div>
        <button onclick="openCreateModal()" class="inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-500/20 transition text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Kategori
        </button>
    </div>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-medium mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Kategori -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-wider border-b border-slate-200/60">
                        <th class="py-4 px-6 font-semibold">#</th>
                        <th class="py-4 px-6 font-semibold">Nama Kategori</th>
                        <th class="py-4 px-6 font-semibold">Slug URL</th>
                        <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($categories as $index => $category)
                        <tr class="hover:bg-slate-50/55 transition">
                            <td class="py-4 px-6 font-medium text-slate-400">
                                {{ $categories->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $category->name }}
                            </td>
                            <td class="py-4 px-6 font-mono text-xs text-slate-500">
                                {{ $category->slug }}
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <!-- Tombol Edit -->
                                <button onclick="openEditModal('{{ $category->id }}', '{{ $category->name }}')" class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-100 font-semibold rounded-lg text-xs transition">
                                    Edit
                                </button>
                                
                                <!-- Tombol Hapus -->
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 font-semibold rounded-lg text-xs transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400">
                                Belum ada data kategori yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Form (Tambah / Edit) -->
<div id="categoryModal" class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100">
        <h3 id="modalTitle" class="text-xl font-extrabold text-slate-900 mb-2">Tambah Kategori Baru</h3>
        <p class="text-slate-500 text-xs mb-6">Masukkan nama kategori untuk pengelompokan workshop.</p>

        <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div id="methodField"></div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Kategori</label>
                    <input type="text" name="name" id="categoryNameInput" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" placeholder="Contoh: Web Development">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-8">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-500 hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-emerald-500 hover:bg-emerald-400 text-slate-950 shadow-lg shadow-emerald-500/20 transition">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('categoryModal');
    const modalTitle = document.getElementById('modalTitle');
    const categoryForm = document.getElementById('categoryForm');
    const categoryNameInput = document.getElementById('categoryNameInput');
    const methodField = document.getElementById('methodField');

    function openCreateModal() {
        modalTitle.innerText = 'Tambah Kategori Baru';
        categoryForm.action = "{{ route('admin.categories.store') }}";
        methodField.innerHTML = '';
        categoryNameInput.value = '';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function openEditModal(id, name) {
        modalTitle.innerText = 'Edit Kategori';
        categoryForm.action = `/admin/categories/${id}`;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        categoryNameInput.value = name;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection