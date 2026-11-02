<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};

class AuthController extends Controller {
    public function loginForm() { return auth()->check() ? redirect('/pesanan') : view('auth.login'); }
    public function login(Request $r) {
        $c = $r->validate(['email' => 'required|email', 'password' => 'required']);
        if (!Auth::attempt($c, $r->boolean('remember')))
            return back()->withInput($r->only('email'))->withErrors(['email' => 'Email atau password salah.']);
        $r->session()->regenerate(); // keranjang tetap aman
        return redirect()->intended('/pesanan');
    }
    public function registerForm() { return auth()->check() ? redirect('/pesanan') : view('auth.register'); }
    public function register(Request $r) {
        $v = $r->validate(['name' => 'required|max:100', 'email' => 'required|email:filter|max:100|unique:users', 'password' => 'required|min:8|confirmed']);
        Auth::login(User::create(['name' => $v['name'], 'email' => $v['email'], 'password' => Hash::make($v['password'])]));
        $r->session()->regenerate();
        return redirect()->intended('/pesanan');
    }
    public function logout(Request $r) { Auth::logout(); $r->session()->regenerateToken(); return redirect('/'); }
}
