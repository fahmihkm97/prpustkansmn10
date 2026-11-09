<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Disamakan dengan nama tabel di migrasi (peminjaman)
    protected $table = 'peminjaman';

    protected $fillable = [
        'trx_code',
        'user_id',
        'book_id',
        'status',
        'borrowed_at',
        'due_date',
        'returned_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'book_id');
    }
}