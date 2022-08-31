<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diskon;

class DiskonController extends Controller
{
    public function index()
    {
        $data['diskon'] = diskon::where('deleted', false)->orderBy('id_diskon', 'asc')->get();
        return view('admin.diskon', $data);
    }

    public function insert_diskon(Request $request){
        $dataDiskon =  $request->validate([
            'keterangan' => ['required'],
            'min_belanja' => ['required']
        ]);
        

       
            $diskon = new Diskon;
            $diskon->keterangan = $dataDiskon['keterangan'];
            $diskon->min_belanja = $dataDiskon['min_belanja'];
            $diskon->nominal = $request->input('nominal');
            $diskon->persen = $request->input('persen');

            if($diskon->save()){
                    return redirect('/diskon')->with('msg', 'Berhasil tambah Diskon');
            }
    }

    public function update_diskon(Request $request){
         $dataDiskon =  $request->validate([
            'keterangan' => ['required'],
            'min_belanja' => ['required']
        ]);
        
         $id = $request->input('id_diskon');
       
        $diskon = Diskon::find($id);
        $diskon->keterangan = $dataDiskon['keterangan'];
        $diskon->min_belanja = $dataDiskon['min_belanja'];
        $diskon->nominal = $request->input('nominal');
        $diskon->persen = $request->input('persen');
        if($diskon->save()){
                return redirect()->route('diskon')->with('msg', 'Berhasil edit Diskon');
        }
        
    }

    public function delete_diskon(Request $request, $id)
    {
        $diskon = Diskon::where('id_diskon', $id)->update(['deleted'=>1]);
        // delete customer
        if($diskon){
            return redirect('/diskon')->with('err-msg', 'Diskon telah dihapus')->withInput();
        }else{
            dd($id);
        }
    }
}
