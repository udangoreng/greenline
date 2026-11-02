@extends('layout')
@section('c')<h1>Daftar</h1><form method="post" action="/daftar" style="max-width:380px">@csrf
@if($errors->any())<p class="err">{{ $errors->first() }}</p>@endif
<input name="name" placeholder="Nama lengkap" value="{{ old('name') }}"><input name="email" type="email" placeholder="Email" value="{{ old('email') }}">
<input name="password" type="password" placeholder="Password (min. 8 karakter)"><input name="password_confirmation" type="password" placeholder="Ulangi password">
<p><button>Buat Akun</button></p><p>Sudah punya akun? <a href="/masuk">Masuk</a></p></form>@endsection
