<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Transaksi;
use \App\Models\Produk;
class LaporanController extends Controller
{
    //
    public function laporan_transaksi(Request $request)
    {
        $tgl = date('d-m-Y');
        $data['transaksi'] = Transaksi::where('tanggal', 'LIKE', '%'.$tgl.'%')->get();
        
        return view('admin.laporan', $data);
    }

    public function laporan_penjualan(Request $request)
    {
        $tgl = date('d-m-Y');
        $transaksi= Transaksi::distinct()->get(['kd_produk']);
        // kode barang  nama barang harga   jumlah  total
        $all_trx = array();
        foreach ($transaksi as $trx){
            $data = Produk::where('id_produk', $trx->kd_produk)->get();
            $jumlah = Transaksi::where('kd_produk', $trx->kd_produk)->sum('qty');
            $harga = $data[0]->harga;
            $dataTransaksi[$trx->kd_produk] = [
                'kd_produk'=> $trx->kd_produk,
                'nama_produk'=> $data[0]->nama_produk,
                'harga'=> $harga,
                'jumlah'=> $jumlah,
                'total'=> $harga*$jumlah
            ]; 
        }

        $data['dataTransaksi'] = $dataTransaksi;
        return view('admin.laporan_penjualan', $data);
    }
}
