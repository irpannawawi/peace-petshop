<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staf extends Model
{
    use HasFactory;
    public $table = 'staf';
    public $timestamps = false;
    protected $fillable = ['nama_staf',
        'ttl',
        'jk',
        'alamat',
        'no_tlp',
    ];
    protected $primaryKey = 'kd_staf';
}
