@if ($paginator->hasPages())
<style>.pg{display:flex;gap:6px;flex-wrap:wrap;justify-content:center;margin:24px 0}.pg a,.pg span{min-width:38px;text-align:center;padding:7px 11px;border:1px solid var(--bd);border-radius:8px;text-decoration:none;color:var(--tx);background:var(--cd)}.pg .on{background:var(--g);border-color:var(--g);color:#fff;font-weight:700}.pg .off{opacity:.4}</style>
<nav class="pg" aria-label="Halaman">
@if ($paginator->onFirstPage())<span class="off">‹</span>@else<a href="{{ $paginator->previousPageUrl() }}" rel="prev">‹</a>@endif
@foreach ($elements as $el)
@if (is_string($el))<span class="off">{{ $el }}</span>@endif
@if (is_array($el))@foreach ($el as $page => $url)@if ($page == $paginator->currentPage())<span class="on">{{ $page }}</span>@else<a href="{{ $url }}">{{ $page }}</a>@endif @endforeach @endif
@endforeach
@if ($paginator->hasMorePages())<a href="{{ $paginator->nextPageUrl() }}" rel="next">›</a>@else<span class="off">›</span>@endif
</nav>
@endif
