<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginLog;
use App\Models\User;

class AuthController extends Controller
{

/*
|--------------------------------------------------------------------------
| FORM LOGIN
|--------------------------------------------------------------------------
*/

public function adminLoginForm()
{
    return view('auth.admin-login');
}

public function petugasLoginForm()
{
    return view('auth.petugas-login');
}

public function pemimpinLoginForm()
{
    return view('auth.pemimpin-login');
}


/*
|--------------------------------------------------------------------------
| CEK IP BLOCK
|--------------------------------------------------------------------------
*/

private function isBlocked($ip)
{
    return LoginLog::where('ip_address',$ip)
        ->where('blocked',true)
        ->exists();
}


/*
|--------------------------------------------------------------------------
| HITUNG LOGIN GAGAL
|--------------------------------------------------------------------------
*/

private function getAttempt($ip)
{
    return LoginLog::where('ip_address',$ip)
        ->where('status','failed')
        ->count() + 1;
}


/*
|--------------------------------------------------------------------------
| LOGIN ADMIN
|--------------------------------------------------------------------------
*/

public function adminLogin(Request $request)
{

    $request->validate([
        'username'=>'required',
        'password'=>'required'
    ]);

    $ip = $request->ip();

    if($this->isBlocked($ip)){
        return back()->with('error','IP anda diblokir karena terlalu banyak percobaan login');
    }

    $username = $request->username;
    $password = $request->password;

    $user = User::where('username',$username)
        ->where('role','admin')
        ->first();

    if(!$user){

        $passwordMatch = false;

        $allUsers = User::where('role','admin')->get();

        foreach($allUsers as $u){
            if(Hash::check($password,$u->password)){
                $passwordMatch = true;
                break;
            }
        }

        $attempt = $this->getAttempt($ip);
        $blocked = $attempt >= 5;

        LoginLog::create([
            'username'=>$username,
            'ip_address'=>$ip,
            'status'=>'failed',
            'user_agent'=>$request->userAgent(),
            'attempt_count'=>$attempt,
            'blocked'=>$blocked
        ]);

        if(!$passwordMatch){
            return back()->with('error','Username dan password anda tidak sesuai');
        }

        return back()->with('error','Username tidak ditemukan');
    }

    if(!Hash::check($password,$user->password)){

        $attempt = $this->getAttempt($ip);
        $blocked = $attempt >= 5;

        LoginLog::create([
            'username'=>$username,
            'ip_address'=>$ip,
            'status'=>'failed',
            'user_agent'=>$request->userAgent(),
            'attempt_count'=>$attempt,
            'blocked'=>$blocked
        ]);

        return back()->with('error','Password salah');
    }

    Auth::login($user);

    LoginLog::create([
        'username'=>$username,
        'ip_address'=>$ip,
        'status'=>'success',
        'user_agent'=>$request->userAgent(),
        'attempt_count'=>0,
        'blocked'=>false
    ]);

    return redirect('/admin')->with('success','Login berhasil');
}


/*
|--------------------------------------------------------------------------
| LOGIN PETUGAS
|--------------------------------------------------------------------------
*/

public function petugasLogin(Request $request)
{

    $request->validate([
        'username'=>'required',
        'password'=>'required'
    ]);

    $ip = $request->ip();

    if($this->isBlocked($ip)){
        return back()->with('error','IP anda diblokir karena terlalu banyak percobaan login');
    }

    $username = $request->username;
    $password = $request->password;

    $user = User::where('username',$username)
        ->where('role','petugas')
        ->first();

    if(!$user){

        $passwordMatch = false;

        $allUsers = User::where('role','petugas')->get();

        foreach($allUsers as $u){
            if(Hash::check($password,$u->password)){
                $passwordMatch = true;
                break;
            }
        }

        $attempt = $this->getAttempt($ip);
        $blocked = $attempt >= 5;

        LoginLog::create([
            'username'=>$username,
            'ip_address'=>$ip,
            'status'=>'failed',
            'user_agent'=>$request->userAgent(),
            'attempt_count'=>$attempt,
            'blocked'=>$blocked
        ]);

        if(!$passwordMatch){
            return back()->with('error','Username dan password anda tidak sesuai');
        }

        return back()->with('error','Username tidak ditemukan');
    }

    if(!Hash::check($password,$user->password)){

        $attempt = $this->getAttempt($ip);
        $blocked = $attempt >= 5;

        LoginLog::create([
            'username'=>$username,
            'ip_address'=>$ip,
            'status'=>'failed',
            'user_agent'=>$request->userAgent(),
            'attempt_count'=>$attempt,
            'blocked'=>$blocked
        ]);

        return back()->with('error','Password salah');
    }

    Auth::login($user);

    LoginLog::create([
        'username'=>$username,
        'ip_address'=>$ip,
        'status'=>'success',
        'user_agent'=>$request->userAgent(),
        'attempt_count'=>0,
        'blocked'=>false
    ]);

    return redirect('/petugas')->with('success','Login berhasil');
}


/*
|--------------------------------------------------------------------------
| LOGIN PEMIMPIN
|--------------------------------------------------------------------------
*/

public function pemimpinLogin(Request $request)
{

    $request->validate([
        'username'=>'required',
        'password'=>'required'
    ]);

    $ip = $request->ip();

    if($this->isBlocked($ip)){
        return back()->with('error','IP anda diblokir karena terlalu banyak percobaan login');
    }

    $username = $request->username;
    $password = $request->password;

    $user = User::where('username',$username)
        ->where('role','pemimpin')
        ->first();

    if(!$user){

        $passwordMatch = false;

        $allUsers = User::where('role','pemimpin')->get();

        foreach($allUsers as $u){
            if(Hash::check($password,$u->password)){
                $passwordMatch = true;
                break;
            }
        }

        if(!$passwordMatch){
            return back()->with('error','Username dan password anda tidak sesuai');
        }

        return back()->with('error','Username tidak ditemukan');
    }

    if(!Hash::check($password,$user->password)){
        return back()->with('error','Password salah');
    }

    Auth::login($user);

    return redirect('/pemimpin')->with('success','Login berhasil');
}


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

public function logout()
{

    if(!Auth::check()){
        return redirect('/');
    }

    $role = Auth::user()->role;

    Auth::logout();

    if($role == 'admin'){
        return redirect('/admin/login')->with('success','Logout berhasil');
    }

    if($role == 'petugas'){
        return redirect('/petugas/login')->with('success','Logout berhasil');
    }

    if($role == 'pemimpin'){
        return redirect('/pemimpin/login')->with('success','Logout berhasil');
    }

    return redirect('/');
}

}