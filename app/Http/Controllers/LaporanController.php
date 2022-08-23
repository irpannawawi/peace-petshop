<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Transaksi;
use \App\Models\Produk;
use \App\Models\Jurnal;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function laporan_transaksi(Request $request)
    {
        $tgl = null;
        $data['transaksi'] = Transaksi::where('tanggal', 'LIKE', '%'.$tgl.'%')->where('status', 'selesai')->orderBy('tanggal', 'desc')->get();
        
        return view('admin.laporan', $data);
    }
    public function laporan_jurnal(Request $request)
    {
        if ($request->input('bln')) {
            $tgl = $request->input('bln').'-'.$request->input('thn');
        }else{
            $tgl = null;
        }
        $data['transaksi'] = Transaksi::where('tanggal', 'LIKE', '%'.$tgl.'%')->where('status', 'selesai')->orderBy('tanggal', 'asc')->get();
        return view('admin.jurnal', $data);
    }

    public function laporan_penjualan(Request $request)
    {
        $tgl = date('m-Y');
        $transaksi= Transaksi::where('status','selesai')->distinct()->orderBy('tanggal', 'desc')->get(['kd_produk']);
        // kode barang  nama barang harga   jumlah  total
        $all_trx = array();
        $dataTransaksi = [];
        foreach ($transaksi as $trx){
            $data = Produk::where('id_produk', $trx->kd_produk)->get();
            $jumlah = Transaksi::where('status','selesai')->where('kd_produk', $trx->kd_produk)->sum('qty');
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

    public function print_laporan_transaksi(Request $request)
    {
        if($request->input('tipe') == 'harian'){
            $tgl = $request->input('tgl').'-'.$request->input('bln').'-'.$request->input('thn');
            $trx = Transaksi::where('tanggal', 'LIKE', $tgl.'%')
                    ->where('status', 'selesai')
                    ->get();
            $data['tgl'] = $tgl;
        }else{
            $tgl = $request->input('bln').'-'.$request->input('thn');
            $trx = Transaksi::where('tanggal', 'LIKE', '%'.$tgl.'%')
                    ->where('status', 'selesai')
                    ->get();
            $bulan = [
                'Januari'   => '01',
                'Februari'  => '02',
                'Maret'     => '03',
                'April'     => '04',
                'Mei'       => '05',
                'Juni'      => '06',
                'Juli'      => '07',
                'Agustus'   => '08',
                'September' => '09',
                'Oktober'   => '10',
                'November'  => '11', 
                'Desember'  => '12',
            ];
            $data['tgl'] = array_search($request->input('bln'), $bulan).' '.$request->input('thn');
        }

        $data['transaksi'] = $trx;
        // return view('pdf.laporan_transaksi', $data);
        $pdf = PDF::loadView('pdf.laporan_transaksi', $data)->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    public function print_laporan_penjualan(Request $request)
    {
        if($request->input('tipe') == 'harian')
        {
            $tgl = $request->input('tgl').'-'.$request->input('bln').'-'.$request->input('thn');
            $transaksi= Transaksi::where('status','selesai')->where('tanggal', 'LIKE', '%'.$tgl.'%')->distinct()->get(['kd_produk']);
            $data['tgl'] = $tgl;

        }else{
            $tgl = $request->input('bln').'-'.$request->input('thn');
            $transaksi= Transaksi::where('status','selesai')->where('tanggal', 'LIKE', '%'.$tgl.'%')->distinct()->get(['kd_produk']);
            $bulan = [
                'Januari'   => '01',
                'Februari'  => '02',
                'Maret'     => '03',
                'April'     => '04',
                'Mei'       => '05',
                'Juni'      => '06',
                'Juli'      => '07',
                'Agustus'   => '08',
                'September' => '09',
                'Oktober'   => '10',
                'November'  => '11', 
                'Desember'  => '12',
            ];
            $data['tgl'] = array_search($request->input('bln'), $bulan).' '.$request->input('thn');
            
        }
        $dataTransaksi = [];
        foreach ($transaksi as $trx){
            $produk       = Produk::where('id_produk', $trx->kd_produk)->get();
            $jumlah     = Transaksi::where('status','selesai')->where('kd_produk', $trx->kd_produk)->sum('qty');
            $harga      = $produk[0]->harga;
            $dataTransaksi[$trx->kd_produk] = [
                'kd_produk'=> $trx->kd_produk,
                'nama_produk'=> $produk[0]->nama_produk,
                'harga'=> $harga,
                'jumlah'=> $jumlah,
                'total'=> $harga*$jumlah
            ]; 
        }

        $data['dataTransaksi'] = $dataTransaksi;
        $pdf = PDF::loadView('pdf.laporan_penjualan', $data)->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    public function print_resi(Request $request, $invoice)
    {
        $data['dataTransaksi'] = Transaksi::where('invoice', $invoice)->get();
        $pdf = PDF::loadView('pdf.resi', $data)->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    public function print_laporan_jurnal(Request $request)
    {
        if($request->input('tipe') == 'harian')
        {
            $tgl = $request->input('tgl').'-'.$request->input('bln').'-'.$request->input('thn');
            $data['tgl'] = $tgl;

        }else{
            $tgl = $request->input('bln').'-'.$request->input('thn');
            $bulan = [
                'Januari'   => '01',
                'Februari'  => '02',
                'Maret'     => '03',
                'April'     => '04',
                'Mei'       => '05',
                'Juni'      => '06',
                'Juli'      => '07',
                'Agustus'   => '08',
                'September' => '09',
                'Oktober'   => '10',
                'November'  => '11', 
                'Desember'  => '12',
            ];
            $data['tgl'] = array_search($request->input('bln'), $bulan).' '.$request->input('thn');
        }
        $data['transaksi'] = Transaksi::where('tanggal', 'LIKE', '%'.$tgl.'%')->where('status', 'selesai')->orderBy('tanggal', 'asc')->get();
        // return view('admin.jurnal', $data);
        $pdf = PDF::loadView('pdf.jurnal', $data)->setPaper('a4', 'potrait');
        return $pdf->stream();
    }
}
