@extends('layout')
@section('c')
    <h1>
        Katalog Bibit</h1>
    <p><a href="/produk">Semua</a>
        @foreach ($types as $t)
            · <a href="/produk?t={{ $t }}">{{ $t }}</a>
        @endforeach
    </p>
    <div class="g">
        @foreach ($products as $p)
            @include('_card')
        @endforeach
    </div>
@endsection
