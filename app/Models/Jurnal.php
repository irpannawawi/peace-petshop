<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'jurnal';
    
    protected $primaryKey = 'id_jurnal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kd_transaksi',
        'id_akun',
        'debit',
        'kredit',
    ];

    public $timestamps = false;

    public function transaksi()
    {
        return $this->hasOne(Pemasukan::class, 'id_transaksi', 'id_transaksi');
    }
    public function akun()
    {
        return $this->hasOne(Akun::class, 'kode_akun', 'kode_akun');
    }
}
