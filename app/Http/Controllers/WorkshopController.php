<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
   public function index(Request $request)
{
    // Ambil input kategori dari URL (jika user klik filter)
    $categoryId = $request->input('category');

    // Query workshop dengan eager loading relasi
    $query = Workshop::with(['registrations', 'category'])->latest();

    // Jika filter kategori dipilih, saring datanya
    if ($categoryId) {
        $query->where('category_id', $categoryId);
    }

    // Gunakan paginate (misal 6 workshop per halaman)
    $workshops = $query->paginate(6)->withQueryString();

    // Ambil semua daftar kategori untuk tombol filter di view
    $categories = \App\Models\Category::all();

    return view('workshops.index', compact('workshops', 'categories'));
}

    public function show(Workshop $workshop)
    {
        // Muat relasi registrations dan category di halaman detail
        $workshop->load(['registrations', 'category']);

        return view('workshops.show', compact('workshop'));
    }

    // Pastikan fungsi store dan update yang kita bahas sebelumnya juga sudah ada di sini ya!
}