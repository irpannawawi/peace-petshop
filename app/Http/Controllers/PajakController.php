<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pajak;

class PajakController extends Controller
{
    public function index()
    {
        $data['pajak'] = Pajak::where(['status'=>1])->get();
        return view('admin.pajak', $data);
    }

    public function insert_pajak(Request $request){
        $datapajak =  $request->validate([
            'tax' => ['required']
        ]);
        

       
            $pajak = new Pajak;
            $pajak->tax = $datapajak['tax'];

            if($pajak->save()){
                    return redirect('/pajak')->with('msg', 'Berhasil Rubah Pajak');
            }
    }

    public function update_pajak(Request $request){
         $datapajak =  $request->validate([
            'tax' => ['required'],
        ]);
        
         $id = $request->input('id_tax');
        $pajak = Pajak::find($id);
        $pajak->tax = $datapajak['tax'];
        if($pajak->save()){
                return redirect()->route('pajak')->with('msg', 'Berhasil edit Pajak');
        }
        
    }

    public function delete_pajak(Request $request, $id)
    {
        $pajak= Pajak::where('id_tax', $id)->update(['status'=>0]);
        // delete customer
            return redirect('/pajak')->with('err-msg', 'Pajak telah dihapus')->withInput();
    }
}
