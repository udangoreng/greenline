@extends('layout')
@section('c')
    <h1>Riwayat Pembelian</h1>
    <div class="g" style="margin-bottom:18px">
        <div class="c">💰 Total belanja<h2>Rp{{ number_format($spent, 0, ',', '.') }}</h2></div>
        <div class="c">🌱 Bibit dibeli<h2>{{ number_format($trees) }}</h2></div>
        <div class="c">🌍 Estimasi CO₂/th<h2>{{ number_format($co2) }} kg</h2></div>
    </div>
    <p>
        @foreach (['' => 'Semua', 'pending' => 'Menunggu', 'paid' => 'Lunas', 'failed' => 'Gagal'] as $k => $l)
            <a href="/pesanan{{ $k ? '?s=' . $k : '' }}" style="{{ request('s', '') === $k ? 'font-weight:700' : '' }}">{{ $l }}</a>{{ $loop->last ? '' : ' · ' }}
        @endforeach
    </p>
    @forelse($orders as $o)
        <div class="c" style="margin-bottom:12px;display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;align-items:center">
            <div>
                <b>{{ $o->code }}</b><br>
                <small>{{ $o->created_at->format('d M Y H:i') }} · Rp{{ number_format($o->total, 0, ',', '.') }}</small><br>
                <small>{{ $o->items->pluck('name')->take(3)->implode(', ') }}{{ $o->items->count() > 3 ? ' +' . ($o->items->count() - 3) . ' lainnya' : '' }}</small>
            </div>
            <div><span class="tag">{{ $o->label }}</span> <a class="btn" href="/pesanan/{{ $o->code }}">Lacak</a></div>
        </div>
    @empty
        <p>Belum ada pesanan. <a href="/produk">Mulai menanam</a></p>
    @endforelse
    {{ $orders->links('pagination') }}
@endsection
