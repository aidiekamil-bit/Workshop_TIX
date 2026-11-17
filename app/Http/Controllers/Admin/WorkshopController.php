<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkshopController extends Controller
{
   public function index(Request $request)
{
    $search = $request->input('search');

    // Query dengan pencarian dan pagination (5 data per halaman)
    $workshops = Workshop::with('registrations')
        ->when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                         ->orWhere('speaker', 'like', "%{$search}%")
                         ->orWhere('description', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(5)
        ->withQueryString(); // Memastikan parameter search tidak hilang saat pindah halaman pagination

    // Data statistik untuk ringkasan di atas (mengambil seluruh data tanpa limit pagination)
    $allWorkshops = Workshop::with('registrations')->get();
    $totalWorkshops = $allWorkshops->count();
    $totalRegistrations = $allWorkshops->sum(function($workshop) {
        return $workshop->registrations->count();
    });
    $totalRevenue = $allWorkshops->sum(function($workshop) {
        return $workshop->price * $workshop->registrations->count();
    });

    return view('admin.workshops.index', compact(
        'workshops', 
        'totalWorkshops', 
        'totalRegistrations', 
        'totalRevenue', 
        'search'
    ));
}

    public function create()
    {
        return view('admin.workshops.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'speaker' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'date' => 'required|date',
            'time' => 'required',
            'quota' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Validasi foto
        ]);

        $data = $request->except('image');

        // Handle Upload Foto
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('workshops', 'public');
        }

        Workshop::create($data);

        return redirect()->route('admin.workshops.index')->with('success', 'Workshop berhasil ditambahkan!');
    }

    // Form Edit Workshop
    public function edit(Workshop $workshop)
    {
        return view('admin.workshops.edit', compact('workshop'));
    }

    // Proses Update Workshop & Foto
    public function update(Request $request, Workshop $workshop)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'speaker' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'date' => 'required|date',
            'time' => 'required',
            'quota' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('image');

        // Handle Upload Foto Baru
        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($workshop->image && Storage::disk('public')->exists($workshop->image)) {
                Storage::disk('public')->delete($workshop->image);
            }
            // Simpan foto baru
            $data['image'] = $request->file('image')->store('workshops', 'public');
        }

        $workshop->update($data);

        return redirect()->route('admin.workshops.index')->with('success', 'Workshop berhasil diperbarui!');
    }

    public function destroy(Workshop $workshop)
    {
        // Hapus file gambar dari storage saat workshop dihapus
        if ($workshop->image && Storage::disk('public')->exists($workshop->image)) {
            Storage::disk('public')->delete($workshop->image);
        }

        $workshop->delete();
        return redirect()->route('admin.workshops.index')->with('success', 'Workshop berhasil dihapus!');
    }
}