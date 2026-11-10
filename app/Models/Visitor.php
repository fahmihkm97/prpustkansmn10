<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    // Arahkan ke nama tabel di database Anda
    protected $table = 'pengunjung';

    protected $fillable = [
        'name',
        'identity',
        'purpose',
    ];
}