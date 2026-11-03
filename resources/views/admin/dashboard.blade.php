@extends('layout')
@section('c')
    @include('admin._nav')<h1>
        Dashboard</h1>
    <div class="g">
        <div class="c">💰 Pendapatan<h2>Rp{{ number_format($revenue, 0, ',', '.') }}</h2>
        </div>
        <div class="c">🧾 Lunas / Pending<h2>{{ $paid }} / {{ $pending }}</h2>
        </div>
        <div class="c">🌱 Bibit terjual<h2>{{ number_format($trees) }}</h2>
        </div>
        <div class="c">🌍 Estimasi CO₂/th<h2>{{ number_format($co2) }} kg</h2>
        </div>
    </div>
    <h2>Stok menipis (≤10)</h2>
    <table>
        @forelse($low as $p)
            <tr>
                <td>{{ $p->name }}</td>
                <td>{{ $p->stock }}</td>
                <td><a href="/admin/produk/{{ $p->id }}/ubah">Ubah</a></td>
        </tr>@empty<tr>
                <td>Aman.</td>
            </tr>
        @endforelse
    </table>
    <h2>Pesanan Terbaru <small><a href="/admin/pesanan">Lihat semua →</a></small></h2>
    <table>
        <tr>
            <th>Kode</th>
            <th>Pembeli</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
        @foreach ($orders as $o)
            <tr>
                <td><a href="/admin/pesanan/{{ $o->code }}">{{ $o->code }}</a></td>
                <td>{{ $o->name }}</td>
                <td>Rp{{ number_format($o->total, 0, ',', '.') }}</td>
                <td>{{ $o->status }}</td>
            </tr>
        @endforeach
    </table>
@endsection
