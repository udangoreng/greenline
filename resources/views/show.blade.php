@extends('layout')
@section('c')
    <div class="c" style="max-width:640px">
        <div class="e">
            @if ($product->photo)
                <img src="{{ $product->photo }}" alt="{{ $product->name }}">@else{{ $product->emoji }}
            @endif
        </div>
        <h1>{{ $product->name }}</h1><i>{{ $product->latin }}</i>
        <p>{{ $product->description }}</p><span class="tag">{{ $product->type }}</span><span class="tag">SDG
            {{ $product->sdg }}</span>
        <h2>Rp{{ number_format($product->price, 0, ',', '.') }}</h2>
        <p>Stok: {{ $product->stock }}</p>
        @if ($product->stock > 0)
            <form method="post" action="/keranjang/tambah/{{ $product->id }}">@csrf<input type="number" name="qty"
                    value="1" min="1" max="{{ $product->stock }}" style="width:90px"> <button>Tambah ke
                Keranjang</button></form>@else<b>Stok habis</b>
        @endif
    </div>
@endsection
