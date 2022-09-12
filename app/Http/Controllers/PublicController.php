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
use App\Models\Akun;
use App\Models\Jurnal;
use App\Models\Diskon;
use App\Models\Pajak;

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
        $data['tax'] = Pajak::get()[0]->tax;
        $data['keranjang'] = Keranjang::where('kd_cust', Auth::user()->customer->kd_cust)->get();
        $data['diskon'] = Diskon::where('deleted', 0)->orderBy('min_belanja', 'asc')->get();
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
        $data['diskon'] = Diskon::where('deleted', 0)->orderBy('min_belanja', 'asc')->get();
        $data['keranjang'] = Keranjang::where('kd_cust', $kd_cust)->get();
        $data['user'] = User::find(Auth::user()->id_user);
        $data['tax'] = Pajak::get()[0]->tax;
        return view('customer.checkout', $data);
    }

    public function do_checkout(Request $request)
    {
        $invoice   = 'BUY-'.date('dmYHis');
        $kd_cust = User::find(Auth::user()->id_user)->customer->kd_cust;
        $keranjang = Keranjang::where('kd_cust', $kd_cust)->get();
        $diskon = Diskon::where('deleted', 0)->orderBy('min_belanja', 'asc')->get();

        foreach ($keranjang as $row)
        {

            // cek diskon
            $has_diskon = null;
            $harga_satuan = 0;
            foreach($diskon as $ds){
                if($row->qty >= $ds->min_belanja){
                    $has_diskon = $ds->id_diskon;
                    break;
                }
            }

            if($has_diskon){
                $disc = Diskon::find($has_diskon);
                if($disc->nominal==null){
                    $harga_satuan = $row->produk->harga-($row->produk->harga*$disc->persen/100);
                }else{
                    $harga_satuan = $row->produk->harga-$disc->nominal;
                    if($harga_satuan<1)$harga_satuan=0;
                }
            }else{
                $harga_satuan = $row->produk->harga;
            }


            $dataTransaksi = [
                'invoice' => $invoice,
                'kd_cust' => $row->kd_cust,
                'kd_produk' => $row->kd_produk,
                'harga_satuan' => $harga_satuan,
                'qty' => $row->qty,
                'tanggal' => date('d-m-Y H:i:s'),
                'pengiriman' =>  $request->input('pengiriman'),
                'pembayaran' => $request->input('pembayaran'),
                'bukti_pembayaran' =>'',
                'status' =>  'menunggu pembayaran',
                'diskon' => $has_diskon,
                'tax_id'=>Pajak::orderBy('id_tax', 'desc')->get()[0]->id_tax
            ];
            
            Transaksi::insert($dataTransaksi);
            
        }
        Keranjang::where('kd_cust', $kd_cust)->delete();
        return redirect()->route('transaksi');

    }
    public function transaksi(Request $request)
    {
        $kd_cust = User::find(Auth::user()->id_user)->customer->kd_cust;
        $trx = Transaksi::where('kd_cust', $kd_cust)->distinct()->orderBy('kd_transaksi', 'desc')->get(['invoice']);
        $data['invoices']= [];

        if($trx->count()>0){
            foreach($trx as $tr)
            {
                $total_per_item = Transaksi::where('invoice', $tr->invoice)
                ->select(Db::raw('transaksi.harga_satuan * transaksi.qty  as total_harga'))
                ->get();
                $data['invoices'][$tr->invoice] = [
                    'invoice'=>$tr->invoice, 
                    'total'=>$total_per_item->sum('total_harga'), 
                    'data'=>Transaksi::where('invoice', $tr->invoice)->get(), 
                    'status'=>Transaksi::where('invoice', $tr->invoice)->get()[0]->status
                ];
            }
        }
        return view('customer.transaksi', $data);
    }    
    
    public function cancel_transaksi($inv)
    {
        $trx = Transaksi::where('invoice', $inv)->delete();
        
        return redirect()->route('transaksi');
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

        // insert ke jurnal
        foreach (Transaksi::where('invoice', $invoice)->get() as $key) {
            $total_transaksi = 0;
            $total_transaksi += $key->harga_satuan*$key->qty; 
            // debit 
            $debit = [
                'kd_transaksi'=>$key->kd_transaksi,
                'kode_akun'=>Akun::where('default', 'Kas Masuk')->get()[0]->kode_akun,
                'debit'=>$total_transaksi,
                'kredit'=>0
            ]; 
            Jurnal::insert($debit);

            // kredit 
            $kredit = [
                'kd_transaksi'=>$key->kd_transaksi,
                'kode_akun'=>Transaksi::where('kd_transaksi', $key->kd_transaksi)->get()[0]->produk->kode_akun,
                'debit'=>0,
                'kredit'=>$total_transaksi
            ]; 
            Jurnal::insert($kredit);
        }


        if(Transaksi::where('invoice', $invoice)->update(['status'=> 'selesai'])){
            return redirect('/transaksi')->with('msg', 'Transaksi Selesai');
        }else{
            return redirect('/transaksi')->with('msg-danger', 'gagal');
        }
    }
}
