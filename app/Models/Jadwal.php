<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    public $table = 'jadwal';
    public $timestamps = false;
    protected $fillable = [
        'kd_transaksi', 
        'kd_cust', 
        'tanggal',   
        'status',    
    ];

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'kd_transaksi', 'kd_transaksi');
    }
    public function customer()
    {
        return $this->hasOne(Customer::class, 'kd_cust', 'kd_cust');
    }
}
