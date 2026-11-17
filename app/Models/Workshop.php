<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Jangan lupa import ini

class Workshop extends Model
{
    protected $guarded = ['id'];

    // Relasi ke tabel registrations (Satu workshop punya banyak pendaftar)
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    // Relasi ke tabel categories (Satu workshop milik satu kategori)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}