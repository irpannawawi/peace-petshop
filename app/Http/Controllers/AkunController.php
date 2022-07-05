<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;

class AkunController extends Controller
{
    public function index()
    {
        $data['akun'] = Akun::orderBy('kode_akun', 'asc')->get();
        return view('admin.akun', $data);
    }

    public function insert_akun(Request $request){
        $userData =  $request->validate([
            'kode_akun' => ['required'],
            'nama_akun' => ['required']
        ]);
        

       
            $akun = new Akun;
            $akun->nama_akun = $userData['nama_akun'];
            $akun->kode_akun = $userData['kode_akun'];
            if($request->input('default')){
                Akun::where('default', '!=', '')->update(['default'=>'']);
                $akun->default = $request->input('default');
            }
            if($akun->save()){
                    return redirect('/akun')->with('msg', 'Berhasil tambah Akun');
            }
    }

    public function update_akun(Request $request){
        $akunData =  $request->validate([
            'kode_akun' => ['required'],
            'nama_akun' => ['required']
        ]);
        

       
            Akun::where('default', '!=', '')->update(['default'=>'']);
            $akun = Akun::find($request->input('id_akun'));
            $akun->kode_akun = $akunData['kode_akun'];
            $akun->nama_akun = $akunData['nama_akun'];
            $akun->default = $request->input('default');
            if($akun->save()){
                    return redirect()->route('akun')->with('msg', 'Berhasil edit Akun');
            }
        
    }

    public function delete_akun(Request $request, $id)
    {
        $akun = Akun::where('id_akun', $id)->delete();
        // delete customer
        if($akun){
            return redirect('/akun')->with('err-msg', 'Akun telah dihapus')->withInput();
        }
    }
}
