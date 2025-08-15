<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
// use RealRashid\SweetAlert\Facades\Alert;


class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function actionLogin(Request $request)
    {
        // return $request;
        $email = $request->email;
        $password = $request->password;
        $credentials = $request->only(['email' => $email, 'password' => $request->password]);
        $user = User::where('email', $email)->first();
        if (!$user) {
            // return "tesss";
            Alert::warning('Upss', 'Mohon Periksa email dan password anda!!');
            return  redirect()->back()->withErrors('Login Gagal. Mohon periksa email dan password anda.');
        }


        // 12345678
        // $2a$12$RNr/8gl5lM2l7.CnshQNzuULQsG86mmDMnqLLJq6MdKhn1Q6eA6AO
        if (password_verify($request->password, $user->password)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        } else {
            return  redirect()->back()->withErrors('Login Gagal. Mohon periksa email dan password anda.');
            // return redirect()->to()->with('messsage', 'isi pesan');
        }
    }
}
