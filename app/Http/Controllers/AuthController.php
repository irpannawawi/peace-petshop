<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \App\Models\User;
use \App\Models\Customer;

class AuthController extends Controller
{

    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        if(Auth::user())
        {
            switch (Auth::user()->role){
                case 'customer':
                    return redirect('/');
                    break;
                default:
                    return redirect('dashboard');
            }
        }
        return view('auth.login');
    }

    public function authenticate (Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // 
            switch (Auth::user()->role) {
                case 'admin':
                    return redirect()->intended('admin/dashboard');
                    break;
                case 'staf':
                    return redirect()->intended('admin/dashboard');
                    break;
                case 'owner':
                    return redirect()->intended('admin/dashboard');
                    break;
                case 'customer':
                    return redirect()->intended('/');
                    break;
                default:
                    // code...
                    break;
            }
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register_view(Request $request)
    {
        return view('auth.register');
    }

    public function act_register(Request $request)
    {
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
                $userData['password'] = Hash::make($userData['password']);
                $user = User::insert($userData);
                if($user){
                    return redirect('/customer')->with('msg', 'Berhasil tambah Customer');
                }else{
                    Customer::where('kd_cust', $cust->kd_cust)->delete();
                }
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/');
    }
}
