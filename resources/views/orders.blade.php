@extends('layout')
@section('c')
    <h1>Pesanan Saya</h1>
    @forelse($orders as $o)
        <div class="c"
            style="margin-bottom:12px;display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;align-items:center">
            <div><b>{{ $o->code }}</b><br><small>{{ $o->created_at->format('d M Y H:i') }} ·
                    Rp{{ number_format($o->total, 0, ',', '.') }}</small></div>
            <div><span class="tag">{{ $o->label }}</span> <a class="btn"
                    href="/pesanan/{{ $o->code }}">Lacak</a></div>
        </div>
    @empty<p>Belum ada pesanan. <a href="/produk">Mulai menanam</a></p>
    @endforelse
@endsection
