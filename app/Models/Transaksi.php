<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    public $table = 'transaksi';
    public $timestamps = false;
    protected $fillable = [
        'invoice', 
        'kd_cust', 
        'kd_produk',   
        'harga_satuan',    
        'qty', 
        'tanggal', 
        'pembayaran',  
        'bukti_pembayaran',    
        'status',  
        'pengiriman',  

    ];
    protected $primaryKey = 'kd_transaksi';

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id_produk', 'kd_produk');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'kd_cust', 'kd_cust');
    }
}
