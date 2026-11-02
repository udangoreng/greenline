@extends('layout')
@section('c')<h1>
        Keranjang</h1>
    @if (!$items->count())
        <p>Kosong. <a href="/produk">Lihat produk</a></p>
    @else
        <form method="post" action="/keranjang/ubah">@csrf<table>
                <tr>
                    <th>Bibit</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                </tr>
                @foreach ($items as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>Rp{{ number_format($p->price, 0, ',', '.') }}</td>
                        <td><input type="number" min="0" name="qty[{{ $p->id }}]" value="{{ $c[$p->id] }}"
                                style="width:80px;margin:0"></td>
                    </tr>
                @endforeach
            </table>
            <p>Jumlah 0 = hapus. 🌍 Estimasi serapan ≈ <b>{{ $items->sum(fn($p) => $p->co2 * $c[$p->id]) }}</b> kg CO₂/tahun.
            </p>
            <button>Perbarui</button> <a class="btn" href="/checkout">Checkout</a>
        </form>
    @endif @endsection
