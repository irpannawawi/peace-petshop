<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Produk;
use \App\Models\Akun;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    //
    public function index()
    {
        $data['dataProduk'] = Produk::get();
        $data['dataAkun'] = Akun::orderBy('kode_akun', 'asc')->get();
        return view('admin.produk', $data);
    }

    public function insert_produk(Request $request){
        $produkData =  $request->validate([
            'nama_produk' => ['required'],
            'deskripsi' => ['required'],
            'kategori' => ['required'],
            'harga' => ['required'],
            'kode_akun' => ['required'],
        ]);
        
        // upload foto if exist
        if($request->file('foto')){
            $file_name = 'prod-'.date('dmYhis').'.jpg';
            $path = $request->foto->storeAs('foto_produk', $file_name);
        }
        $produk = new Produk;
        $produk->nama_produk        = $produkData['nama_produk'];
        $produk->deskripsi          = $produkData['deskripsi'];
        $produk->kategori           = $produkData['kategori'];
        $produk->harga              = $produkData['harga'];
        $produk->kode_akun          = $produkData['kode_akun'];
        $produk->foto               = $file_name; 
        if($produk->save()){
            return redirect('/produk')->with('msg', 'Berhasil tambah Produk');
        }
    }

    public function update_produk(Request $request){
        $produkData =  $request->validate([
            'nama_produk' => ['required'],
            'deskripsi' => ['required'],
            'kategori' => ['required'],
            'harga' => ['required'],
            'kode_akun' => ['required'],
        ]);
        
        // upload foto if exist
        $produk = Produk::find($request->input('id_produk'));
        $produk->nama_produk        = $produkData['nama_produk'];
        $produk->deskripsi          = $produkData['deskripsi'];
        $produk->kategori           = $produkData['kategori'];
        $produk->harga              = $produkData['harga'];
        $produk->kode_akun          = $produkData['kode_akun'];

        if($request->file('foto')){
            // remove old foto 
            Storage::delete(asset('foto_produk/'.$produk->foto));
            // then upload new 
            $file_name = 'prod-'.date('dmYhis').'.jpg';
            $path = $request->foto->storeAs('foto_produk', $file_name);
        }else{
            $file_name = $produk->foto;
        }

        $produk->foto  = $file_name; 
        if($produk->save()){
            return redirect('/produk')->with('msg', 'Berhasil ubah Produk');
        }
    }

    public function delete_produk(Request $request, $id)
    {
        // delete produk
        if(Produk::where('id_produk', $id)->delete()){
            return redirect('/produk')->with('err-msg', 'Produk telah dihapus')->withInput();
        }
    }
}
