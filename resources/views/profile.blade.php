@extends('layout')
@section('c')
    <h1>Profil Saya</h1>
    @if (session('ok'))<p style="color:var(--g)"><b>✓ {{ session('ok') }}</b></p>@endif
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px;max-width:860px">
        <form method="post" action="/profil">@csrf
            <h2>Data Diri</h2>
            @if ($errors->any() && !$errors->hasBag('password'))<p class="err">{{ $errors->first() }}</p>@endif
            <input name="name" placeholder="Nama lengkap" value="{{ old('name', $user->name) }}">
            <input name="email" type="email" placeholder="Email" value="{{ old('email', $user->email) }}">
            <input name="phone" placeholder="No. HP" value="{{ old('phone', $user->phone) }}">
            <textarea name="address" rows="3" placeholder="Alamat pengiriman utama">{{ old('address', $user->address) }}</textarea>
            <small>Terisi otomatis saat checkout.</small><p><button>Simpan</button></p>
        </form>
        <form method="post" action="/profil/password">@csrf
            <h2>Ganti Password</h2>
            @if ($errors->hasBag('password'))<p class="err">{{ $errors->getBag('password')->first() }}</p>@endif
            <input name="current_password" type="password" placeholder="Password saat ini">
            <input name="password" type="password" placeholder="Password baru (min. 8 karakter)">
            <input name="password_confirmation" type="password" placeholder="Ulangi password baru">
            <p><button>Ganti Password</button></p>
        </form>
    </div>
    <p><a href="/pesanan">← Riwayat pembelian</a></p>
@endsection
