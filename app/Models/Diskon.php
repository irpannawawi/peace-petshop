<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;
    protected $table = 'diskon';
    
    protected $primaryKey = 'id_diskon';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_diskon',
        'keterangan',
        'min_belanja',
        'nominal',
        'persen',
    ];

    public $timestamps = false;

    public function transaksi()
    {
       return $this->hasMany(Transaksi::class, 'id_diskon', 'diskon');
    }
}
