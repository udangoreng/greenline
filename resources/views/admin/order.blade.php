@extends('layout')
@section('c')
    @include('admin._nav')<h1>
        {{ $order->code }}</h1>
    <p>Status: <b>{{ $order->status }}</b> · {{ $order->created_at }}</p>
    <p>{{ $order->name }} · {{ $order->email }} · {{ $order->phone }}<br>{{ $order->address }}</p>
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
    <h2>Status Pesanan</h2>
    @error('stage')
        <p class="err">{{ $message }}</p>
    @enderror
    @if ($order->stage === 'done')
        <p>✅ Selesai: dikonfirmasi pembeli.@if ($order->tracking_no) Resi: <b>{{ $order->tracking_no }}</b>@endif</p>
    @else
    <form method="post" action="/admin/pesanan/{{ $order->code }}" style="max-width:380px">@csrf
        <select name="stage" style="width:100%;padding:9px;margin-bottom:10px">
            <option value="">Dibayar</option>
            @foreach (['processing' => 'Diproses', 'shipped' => 'Dikirim'] as $k => $l)
                <option value="{{ $k }}" @selected($order->stage == $k)>{{ $l }}</option>
            @endforeach
        </select>
        <input name="tracking_no" placeholder="No. resi (opsional)" value="{{ $order->tracking_no }}"><button>Simpan</button>
    </form>
    @endif
@endsection
