@extends('layout')
@section('c')<h1>
        Pesanan {{ $order->code }}</h1>
    @if (session('ok'))<p style="color:var(--g)"><b>✓ {{ session('ok') }}</b></p>@endif
    <style>
        .tl {
            display: flex;
            margin: 22px 0;
            isolation: isolate
        }

        .st {
            flex: 1;
            text-align: center;
            position: relative;
            font-size: .85rem;
            color: var(--mu)
        }

        .st i {
            display: grid;
            place-items: center;
            width: 32px;
            height: 32px;
            margin: 0 auto 6px;
            border-radius: 50%;
            border: 2px solid var(--bd);
            font-style: normal;
            background: var(--bg)
        }

        .st:not(:first-child)::before {
            content: '';
            position: absolute;
            top: 16px;
            right: 50%;
            width: 100%;
            height: 2px;
            background: var(--bd);
            z-index: -1
        }

        .st.ok {
            color: var(--g);
            font-weight: 600
        }

        .st.ok i {
            background: var(--g);
            border-color: var(--g);
            color: #fff
        }

        .st.ok:not(:first-child)::before {
            background: var(--g)
        }
    </style>
    @php($cur = $order->status === 'paid' ? array_search($order->stage ?? 'paid', array_keys(\App\Models\Order::STEPS)) : -1)
    @if ($order->status !== 'failed')
        <div class="tl">
            @foreach (\App\Models\Order::STEPS as $k => $l)
                <div class="st {{ $loop->index <= $cur ? 'ok' : '' }}">
                    <i>{{ $loop->index <= $cur ? '✓' : $loop->iteration }}</i>{{ $l }}</div>
            @endforeach
        </div>
        @if ($order->tracking_no)
            <p>No. resi: <b>{{ $order->tracking_no }}</b></p>
        @endif
        @if ($order->status === 'paid' && $order->stage === 'shipped')
            <div class="c" style="max-width:460px;margin:14px 0">
                <p style="margin-top:0">Bibit sudah sampai? Konfirmasi agar pesanan ditandai selesai.</p>
                <form method="post" action="/pesanan/{{ $order->code }}/selesai" onsubmit="return confirm('Pastikan bibit sudah Anda terima. Lanjutkan?')">@csrf
                    <button>✅ Pesanan Diterima / Selesai</button>
                </form>
            </div>
        @endif
    @endif
    <p>Status:
        <b>{{ ['paid' => '✅ Lunas', 'failed' => '❌ Gagal/Kedaluwarsa', 'pending' => '⏳ Menunggu pembayaran'][$order->status] }}</b>
    </p>
    <table>
        @foreach ($order->items as $i)
            <tr>
                <td>{{ $i->name }} × {{ $i->qty }}</td>
                <td>Rp{{ number_format($i->price * $i->qty, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr>
            <td>Ongkir ({{ config('shop.zones.' . $order->zone . '.label') }})</td>
            <td>Rp{{ number_format($order->shipping, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total</th>
            <th>Rp{{ number_format($order->total, 0, ',', '.') }}</th>
        </tr>
    </table>
    @if ($order->status === 'pending')
        <p><button id="pay">Bayar Sekarang</button></p>
        <script
            src="{{ config('services.midtrans.production') ? 'https://app.midtrans.com' : 'https://app.sandbox.midtrans.com' }}/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>
        <script>
            document.getElementById('pay').onclick = () => snap.pay('{{ $order->snap_token }}', {
                onSuccess: () => location.reload(),
                onPending: () => location.reload(),
                onError: () => location.reload()
            })
        </script>
    @elseif($order->status === 'paid')
        <p>Terima kasih sudah ikut menanam untuk bumi 🌱</p>
    @endif @endsection
