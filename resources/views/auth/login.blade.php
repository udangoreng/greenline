@extends('layout')
@section('c')<h1>Masuk</h1><form method="post" action="/masuk" style="max-width:380px">@csrf
@error('email')<p class="err">{{ $message }}</p>@enderror
<input name="email" type="email" placeholder="Email" value="{{ old('email') }}"><input name="password" type="password" placeholder="Password">
<label><input type="checkbox" name="remember" style="width:auto"> Ingat saya</label><p><button>Masuk</button></p>
<p>Belum punya akun? <a href="/daftar">Daftar</a></p></form>@endsection
