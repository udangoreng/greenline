<div class="c">
    <div class="e">
        @if ($p->photo)
            <img src="{{ $p->photo }}" alt="{{ $p->name }}" loading="lazy">
        @endif
    </div>
    <h3><a href="/produk/{{ $p->id }}">{{ $p->name }}</a></h3><i>{{ $p->latin }}</i><br>
    <span class="tag">{{ $p->type }}</span>
    <p><b>Rp{{ number_format($p->price, 0, ',', '.') }}</b></p>
    @if ($p->stock > 0)
        <form method="post" action="/keranjang/tambah/{{ $p->id }}">@csrf<button>+ Keranjang</button></form>
    @else<b>Stok habis</b>
    @endif
</div>
