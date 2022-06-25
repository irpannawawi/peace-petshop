<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    public $table = 'keranjang';
    public $timestamps = false;
    protected $fillable = [
        'kd_cust',
        'kd_produk',
        'qty'
    ];
    protected $primaryKey = 'kd_keranjang';

    public function produk(){
        return $this->hasOne(Produk::class, 'id_produk', 'kd_produk');
    }
}
