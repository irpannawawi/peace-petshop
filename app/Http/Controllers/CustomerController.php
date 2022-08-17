<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \App\Models\User;
use \App\Models\Customer;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $data['custs'] = User::where('role','customer')->get();
        return view('admin.customer', $data);
    }

    public function insert_customer(Request $request){
        $userData =  $request->validate([
            'nama' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $userData['role'] = 'customer';
    

        if($userData['password'] !== $request->input('confirm_password')){
            return redirect('/customer')->with('err-msg', 'password tidak cocok')->withInput();
        }else{
            $cust = new Customer;
            $cust->nama_cust = $userData['nama'];
            $cust->ttl       = $request->input('ttl');
            $cust->jk        = $request->input('jk');
            $cust->alamat    = $request->input('alamat');
            $cust->no_tlp    = $request->input('tlp');

            if($cust->save()){
                $userData['kd_cust'] = $cust->kd_cust;
                $userData['password'] = Hash::make($request->input('password'));
                $user = User::insert($userData);
                if($user){
                    return redirect('/customer')->with('msg', 'Berhasil tambah Customer');
                }else{
                    Customer::where('kd_cust', $cust->kd_cust)->delete();
                }
            }
        }
    }

    public function update_customer(Request $request){
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
            return redirect('/customer')->with('err-msg', 'password tidak cocok')->withInput();
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
                $cust = Customer::where('kd_cust', $user->kd_cust)->get()[0];
                $cust->nama_cust = $userData['nama'];
                $cust->ttl       = $request->input('ttl');
                $cust->jk        = $request->input('jk');
                $cust->alamat    = $request->input('alamat');
                $cust->no_tlp    = $request->input('tlp');
                if($cust->save()){
                    return redirect('/customer')->with('msg', 'Berhasil edit Customer');
                }
            }
        }
    }

    public function delete_customer(Request $request, $id)
    {
        $user = User::where('id_user', $id)->get()[0];
        // delete customer
        Customer::where('kd_cust', $user->kd_cust)->delete();

        if($user->delete()){
            return redirect('/customer')->with('err-msg', 'Pengguna telah dihapus')->withInput();
        }
    }
}
