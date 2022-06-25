<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Transaksi;
use \App\Models\Jadwal;

class TransaksiController extends Controller
{
    //
    public function index(Request $request)
    {
        $trx = Transaksi::where('status','!=', 'menunggu pembayaran')->distinct()->orderBy('invoice', 'desc')->get(['invoice']);
        foreach($trx as $tr)
        {
            $data['invoices'][] = ['invoice'=>$tr->invoice, 'data'=>Transaksi::where('invoice', $tr->invoice)->get(), 'status'=>Transaksi::where('invoice', $tr->invoice)->get()[0]->status];
        }
        
        return view('admin.transaksi', $data);
    }

    public function terima_transaksi(Request $request, $invoice)
    {
        // cek jika di invoice terdapat grooming
        $transaksi = Transaksi::where('invoice', $invoice)->get();
        foreach ($transaksi as $trx)
        {
            if($trx->produk->kategori == 'Perawatan Hewan'){
                $jadwal = new Jadwal;
                $jadwal->kd_transaksi = $trx->kd_transaksi;
                $jadwal->kd_cust = $trx->kd_cust;
                $jadwal->tanggal = date('d-m-Y', strtotime("+1 days"));
                $jadwal->status ='menunggu';
                $jadwal->save();
            }
        }

        Transaksi::where('invoice', $invoice)->update(['status'=>'pesanan diterima']);
        return redirect('/a/transaksi');
    }
    public function batalkan_transaksi(Request $request, $invoice)
    {
        Transaksi::where('invoice', $invoice)->update(['status'=>'pesanan dibatalkan']);
        return redirect('/a/transaksi');
    }
}
