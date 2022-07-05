<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;
    protected $table = 'akun';
    
    protected $primaryKey = 'id_akun';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_akun',
        'nama_akun',
    ];

    public $timestamps = false;

    public function produk()
    {
       return $this->hasMany(Produk::class, 'kode_akun', 'kredit_akun_id');
    }
}
