<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public $table = 'customer';
    public $timestamps = false;
    protected $fillable = [
        'nama_cust',
        'ttl', 
        'jk',  
        'alamat',
        'no_tlp',
    ];
    protected $primaryKey = 'kd_cust';
}
