<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    // 
    public function index()
    {
        $data['users'] = User::where('role','admin')->orwhere('role', 'owner')->get();
        return view('admin.pengguna', $data);
    }

    public function insert_user(Request $request){
        $userData =  $request->validate([
            'nama' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required'],
        ]);
        if($userData['password'] !== $request->input('confirm_password')){
            return redirect('/admin/pengguna')->with('err-msg', 'password tidak cocok')->withInput();
        }else{
            $userData['password'] = Hash::make($userData['password']);
            User::insert($userData);
            return redirect('admin/pengguna')->with('msg', 'Berhasil tambah pengguna');
        }
    }

    public function update_user(Request $request){
        $userData =  $request->validate([
            'nama' => ['required'],
            'email' => ['required', 'email'],
            'role' => ['required'],
        ]);
        $id_user = $request->input('id_user');

        if($request->input('password') !== $request->input('confirm_password')){
            return redirect('/admin/pengguna')->with('err-msg', 'password tidak cocok')->withInput();
        }else{

            // jika password diisi
            if(!empty($request->input('password')))
            {
                $userData['password'] = Hash::make($request->input('password'));
            }
            User::where('id_user', $id_user)->update($userData);
            return redirect('admin/pengguna')->with('msg', 'Berhasil edit pengguna');
        }
    }

    public function delete_user(Request $request, $id)
    {
        if(User::where('id_user', $id)->delete()){
            return redirect('/admin/pengguna')->with('err-msg', 'Pengguna telah dihapus')->withInput();
        }
    }
}
