@extends('layout')
@php($sub = $items->sum(fn($p) => $p->price * $c[$p->id]))@php($q = array_sum($c))
@section('c')
    <h1>
        Checkout</h1>
    <form method="post" action="/checkout" style="max-width:480px">@csrf @if ($errors->any())
            <p class="err">{{ $errors->first() }}</p>
        @endif
        <input name="name" placeholder="Nama lengkap" value="{{ old('name', auth()->user()->name) }}"><input name="email"
            type="email" placeholder="Email" value="{{ old('email', auth()->user()->email) }}">
        <input name="phone" placeholder="No. HP" value="{{ old('phone', auth()->user()->phone) }}">
        <textarea name="address" placeholder="Alamat pengiriman" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
        <select name="zone" id="z" style="width:100%;padding:9px;margin-bottom:10px">
            <option value="">Pilih wilayah pengiriman</option>
            @foreach (config('shop.zones') as $k => $z)
                <option value="{{ $k }}" data-r="{{ $z['rate'] }}" @selected(old('zone') == $k)>
                    {{ $z['label'] }} (Rp{{ number_format($z['rate'], 0, ',', '.') }}/kg)</option>
            @endforeach
        </select>
        <p>Subtotal: Rp{{ number_format($sub, 0, ',', '.') }}<br>Ongkir ({{ $q }} kg): <span
                id="sh">-</span><br><b>Total: <span id="tt">Rp{{ number_format($sub, 0, ',', '.') }}</span></b>
        </p>
        <button>Buat Pesanan &amp; Bayar</button>
    </form>
    <script>
        const S = {{ $sub }},
            Q = {{ $q }},
            z = document.getElementById('z');
        z.onchange = () => {
            const r = +z.selectedOptions[0].dataset.r || 0;
            document.getElementById('sh').textContent = r ? 'Rp' + (r * Q).toLocaleString('id-ID') : '-';
            document.getElementById('tt').textContent = 'Rp' + (S + r * Q).toLocaleString('id-ID')
        };
        z.onchange()
    </script>
@endsection
