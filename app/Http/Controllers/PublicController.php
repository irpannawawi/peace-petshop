<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Db;
use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\Jadwal;
use App\Models\Produk;
use App\Models\User;

class PublicController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('home');
    }
    public function produk_view(Request $request)
    {
        $data['produk'] = Produk::get();
        return view('customer.produk', $data);
    }    

    public function keranjang(Request $request)
    {
        $data['keranjang'] = Keranjang::where('kd_cust', Auth::user()->customer->kd_cust)->get();
        $data['total_bayar'] = 0;
        foreach ($data['keranjang'] as $row)
        {
            $data['total_bayar'] += $row->qty*$row->produk->harga;
        }
        return view('customer.keranjang', $data);
    }

    public function add_keranjang(Request $request, $id)
    {
        $id_produk = $id;
        $kd_user = User::find(Auth::user()->id_user)->customer->kd_cust;

        Keranjang::insert(['kd_cust'=>$kd_user, 'kd_produk'=>$id_produk, 'qty'=>1]);
        return redirect()->route('keranjang');
    }

    public function update_keranjang(Request $request, $id)
    {
        $qty = $request->input('qty');
        $keranjang = Keranjang::find($id);
        $keranjang->qty = $qty;
        $keranjang->save();
        return redirect()->route('keranjang');
    }
    public function delete_keranjang(Request $request, $id)
    {
        Keranjang::find($id)->delete();
        return redirect()->route('keranjang');
    }
    public function checkout(Request $request)
    {
        $kd_cust = User::find(Auth::user()->id_user)->customer->kd_cust;
        $data['keranjang'] = Keranjang::where('kd_cust', $kd_cust)->get();
        $data['user'] = User::find(Auth::user()->id_user);
        return view('customer.checkout', $data);
    }

    public function do_checkout(Request $request)
    {
        $invoice   = 'BUY-'.date('dmYHis');
        $kd_cust = User::find(Auth::user()->id_user)->customer->kd_cust;
        $keranjang = Keranjang::where('kd_cust', $kd_cust)->get();
        foreach ($keranjang as $row)
        {
            $dataTransaksi = [
                'invoice' => $invoice,
                'kd_cust' => $row->kd_cust,
                'kd_produk' => $row->kd_produk,
                'harga_satuan' => $row->produk->harga,
                'qty' => $row->qty,
                'tanggal' => date('d-m-Y H:i:s'),
                'pengiriman' =>  $request->input('pengiriman'),
                'pembayaran' => $request->input('pembayaran'),
                'bukti_pembayaran' =>'',
                'status' =>  'menunggu pembayaran'
            ];
            Transaksi::insert($dataTransaksi);
            
        }
        Keranjang::where('kd_cust', $kd_cust)->delete();
        return redirect()->route('transaksi');

    }
    public function transaksi(Request $request)
    {
        $kd_cust = User::find(Auth::user()->id_user)->customer->kd_cust;
        $trx = Transaksi::where('kd_cust', $kd_cust)->distinct()->orderBy('invoice', 'desc')->get(['invoice']);
        foreach($trx as $tr)
        {
            $total_per_item = Transaksi::where('invoice', $tr->invoice)
                        ->select(Db::raw('transaksi.harga_satuan * transaksi.qty as total_harga'))
                        ->get();
            $data['invoices'][$tr->invoice] = ['invoice'=>$tr->invoice, 'total'=>$total_per_item->sum('total_harga'), 'data'=>Transaksi::where('invoice', $tr->invoice)->get(), 'status'=>Transaksi::where('invoice', $tr->invoice)->get()[0]->status];
        }
        return view('customer.transaksi', $data);
    }


    public function transaksi_upload_pembayaran(Request $request)
    {
        $invoice = $request->input('id');
        if($request->hasFile('bukti_pembayaran')){
            $filename = $invoice.'.jpg';
            $request->bukti_pembayaran->storeAs('bukti_pembayaran', $filename);
            Transaksi::where('invoice', $invoice)->update(['bukti_pembayaran'=> $filename, 'status'=>'pesanan terkirim']);
            return redirect()->route('transaksi')->with('msg', 'Berhasil upload bukti pembayaran');
        }else{
            return redirect()->route('transaksi')->withInput();
        }
    }    
    public function konfirmasi_transaksi(Request $request, $invoice)
    {
        // cek jika di invoice terdapat grooming
        $transaksi = Transaksi::where('invoice', $invoice)->get();
        foreach ($transaksi as $trx)
        {
            Jadwal::where('kd_transaksi', $trx->kd_transaksi)->update(['status'=>'selesai']);
        }

        if(Transaksi::where('invoice', $invoice)->update(['status'=> 'selesai'])){
            return redirect('/transaksi')->with('msg', 'Berhasil upload bukti pembayaran');
        }else{
            return redirect('/transaksi')->with('msg-danger', 'gagal');
        }
    }
}
