<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Transaksi;
class LaporanController extends Controller
{
    //
    public function index(Request $request)
    {
        $tgl = date('d-m-Y');
        $data['transaksi'] = Transaksi::where('tanggal', 'LIKE', '%'.$tgl.'%')->get();
        
        return view('admin.laporan', $data);
    }
}
