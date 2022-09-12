<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pajak extends Model
{
    use HasFactory;
    public $table = 'pajak';
    public $timestamps = false;
    protected $fillable = [
        'tax'

    ];
    protected $primaryKey = 'id_tax';

}
