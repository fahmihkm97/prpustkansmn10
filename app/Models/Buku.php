<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    // Disamakan dengan nama tabel di migrasi (buku)
    protected $table = 'buku';

    protected $fillable = [
        'title',
        'author',
        'category',
        'stock',
        'cover_url',
        'cover_image',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'book_id');
    }
}