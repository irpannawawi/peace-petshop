<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Jadwal;

class JadwalController extends Controller
{
    //
    public function index(Request $request)
    {
        $data['jadwal'] = Jadwal::orderBy('tanggal', 'desc')->get();
        return view('admin.jadwal', $data);
    }
}
