<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \App\Models\User;
use \App\Models\Staf;

class StafController extends Controller
{
    //

    // 
    public function index()
    {
        $data['stafs'] = User::where('role','admin')->get();
        return view('admin.staf', $data);
    }

    public function insert_staf(Request $request){
        $userData =  $request->validate([
            'nama' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $userData['role'] = 'admin';
        

        if($userData['password'] !== $request->input('confirm_password')){
            return redirect('/staf')->with('err-msg', 'password tidak cocok')->withInput();
        }else{
            $staf = new Staf;
            $staf->nama_staf = $userData['nama'];
            $staf->ttl       = $request->input('ttl');
            $staf->jk        = $request->input('jk');
            $staf->alamat    = $request->input('alamat');
            $staf->no_tlp    = $request->input('tlp');

            if($staf->save()){
                $userData['kd_staf'] = $staf->kd_staf;
                $userData['password'] = Hash::make($userData['password']);
                $user = User::insert($userData);
                if($user){
                    return redirect('/staf')->with('msg', 'Berhasil tambah staf');
                }else{
                    Staf::where('kd_staf', $staf->kd_staf)->delete();
                }
            }
        }
    }

    public function update_staf(Request $request){
        $userData =  $request->validate([
            'nama' => ['required'],
            'jk' => ['required'],
            'ttl' => ['required'],
            'alamat' => ['required'],
            'email' => ['required', 'email'],
            'tlp' => ['required'],
        ]);

        $id_user = $request->input('id_user');
        $user = User::where('id_user',$id_user)->get()[0];

        if($request->input('password') !== $request->input('confirm_password')){
            return redirect('/admin/pengguna')->with('err-msg', 'password tidak cocok')->withInput();
        }else{

            // jika password diisi
            if(!empty($request->input('password')))
            {
                $userData['password'] = Hash::make($request->input('password'));
            }else{
                $userData['password'] = $user->password;
            }

            $user->nama = $userData['nama'];
            $user->email = $userData['email'];
            $user->password = $userData['password'];
            
            if ($user->save()) {
                $staf = Staf::where('kd_staf', $user->kd_staf)->get()[0];
                $staf->nama_staf = $userData['nama'];
                $staf->ttl       = $request->input('ttl');
                $staf->jk        = $request->input('jk');
                $staf->alamat    = $request->input('alamat');
                $staf->no_tlp    = $request->input('tlp');
                if($staf->save()){
                    return redirect('/staf')->with('msg', 'Berhasil edit pengguna');
                }
            }
        }
    }

    public function delete_staf(Request $request, $id)
    {
        $user = User::where('id_user', $id)->get()[0];
        // delete staf
        Staf::where('kd_staf', $user->kd_staf)->delete();

        if($user->delete()){
            return redirect('/staf')->with('err-msg', 'Pengguna telah dihapus')->withInput();
        }
    }
}
