<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    // Satu kategori memiliki banyak workshop
    public function workshops()
    {
        return $this->hasMany(Workshop::class);
    }
}
