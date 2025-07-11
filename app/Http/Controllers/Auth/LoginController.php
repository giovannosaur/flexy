<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Bisa login pakai email ATAU nik
        $request->validate([
            'login'    => 'required',
            'password' => 'required',
        ]);

        // Cek field login: email atau nik
        $user = User::where('email', $request->login)
                    ->orWhere('nik', $request->login)
                    ->where('status', 'Active')
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
              // redirect ke halaman sukses (misal /dashboard)
            return redirect('/dashboard');
        }

        return back()->withErrors(['login' => 'NIK/email atau password salah atau akun nonaktif!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
