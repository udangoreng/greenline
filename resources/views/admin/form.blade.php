@extends('layout')
@section('c')
    @include('admin._nav')<h1>
        {{ $p->exists ? 'Ubah' : 'Tambah' }} Produk</h1>
    <form method="post" action="/admin/produk{{ $p->exists ? '/' . $p->id : '' }}" enctype="multipart/form-data"
        style="max-width:520px">@csrf @if ($errors->any())
            <p class="err">{{ $errors->first() }}</p>
        @endif
        @foreach (['name' => 'Nama', 'latin' => 'Nama latin', 'type' => 'Jenis (Mangrove/Peneduh/Kayu/Buah/…)', 'price' => 'Harga (Rp)', 'co2' => 'Estimasi CO₂ kg/th', 'stock' => 'Stok'] as $k => $l)
            <label>{{ $l }}<input name="{{ $k }}" value="{{ old($k, $p->$k) }}"></label>
        @endforeach
        <label>Deskripsi
            <textarea name="description" rows="4">{{ old('description', $p->description) }}</textarea>
        </label><label>Foto (JPG/PNG, maks 2 MB)<input type="file" name="image" accept="image/*"></label>
        @if ($p->photo)
            <img src="{{ $p->photo }}" style="max-width:160px;border-radius:8px"><br>
        @endif
        <button>Simpan</button>
    </form>
@endsection
