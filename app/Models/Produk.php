<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    public $table = 'produk';
    public $timestamps = false;
    protected $fillable = [
        'kategori', // Makanan / Perawatan Hewan
        'nama_produk',
        'deskripsi',
        'foto',
        'harga',
    ];
    protected $primaryKey = 'id_produk';
}
