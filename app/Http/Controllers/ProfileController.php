<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller {
    public function show() { return view('profile', ['user' => auth()->user()]); }
    public function update(Request $r) {
        $u = $r->user();
        $v = $r->validate([
            'name' => 'required|max:100',
            'email' => ['required', 'email:filter', 'max:100', Rule::unique('users')->ignore($u->id)],
            'phone' => 'nullable|max:20', 'address' => 'nullable|max:500',
        ]);
        $u->forceFill($v)->save();
        return back()->with('ok', 'Profil diperbarui.');
    }
    public function password(Request $r) {
        $v = $r->validateWithBag('password', ['current_password' => 'required|current_password', 'password' => 'required|min:8|confirmed']);
        $r->user()->forceFill(['password' => Hash::make($v['password'])])->save();
        return back()->with('ok', 'Password berhasil diganti.');
    }
}
