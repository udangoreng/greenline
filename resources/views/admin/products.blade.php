@extends('layout')
@section('c')
    @include('admin._nav')<h1>
        Produk</h1><a class="btn" href="/admin/produk/baru">+ Produk baru</a>
    @error('x')
        <p class="err">{{ $message }}</p>
    @enderror
    <table>
        <tr>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>
        @foreach ($products as $p)
            <tr>
                <td>{{ $p->emoji }} {{ $p->name }}</td>
                <td>Rp{{ number_format($p->price, 0, ',', '.') }}</td>
                <td>{{ $p->stock }}</td>
                <td><a href="/admin/produk/{{ $p->id }}/ubah">Ubah</a>
                    <form method="post" action="/admin/produk/{{ $p->id }}" style="display:inline"
                        onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button
                            style="padding:2px 8px;background:#c0392b">Hapus</button></form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
