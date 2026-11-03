@extends('layout')
@section('c')
    @include('admin._nav')
    <h1>Semua Pesanan</h1>
    <form method="get" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px">
        <input name="q" value="{{ request('q') }}" placeholder="Cari kode / nama / email" style="max-width:280px;margin:0">
        <select name="s" style="padding:9px;margin:0">
            <option value="">Semua status</option>
            @foreach (['pending' => 'Menunggu pembayaran', 'paid' => 'Dibayar', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'done' => 'Selesai', 'failed' => 'Gagal'] as $k => $l)
                <option value="{{ $k }}" @selected(request('s') === $k)>{{ $l }}</option>
            @endforeach
        </select>
        <button>Cari</button>
    </form>
    <div style="overflow-x:auto"><table>
        <tr><th>Kode</th><th>Tanggal</th><th>Pembeli</th><th>Total</th><th>Status</th></tr>
        @forelse ($orders as $o)
            <tr>
                <td><a href="/admin/pesanan/{{ $o->code }}">{{ $o->code }}</a></td>
                <td>{{ $o->created_at->format('d M Y H:i') }}</td>
                <td>{{ $o->name }}<br><small>{{ $o->email }}</small></td>
                <td>Rp{{ number_format($o->total, 0, ',', '.') }}</td>
                <td><span class="tag">{{ $o->label }}</span></td>
            </tr>
        @empty
            <tr><td colspan="5">Tidak ada pesanan.</td></tr>
        @endforelse
    </table></div>
    {{ $orders->links('pagination') }}
@endsection
