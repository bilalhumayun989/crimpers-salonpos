@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination" style="display:flex;align-items:center;justify-content:center;gap:5px;flex-wrap:wrap;font-family:'Outfit',sans-serif;">

    {{-- Prev arrow --}}
    @if ($paginator->onFirstPage())
        <span style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:9px;border:1.5px solid #E8EAED;background:#F4F5F7;color:#C0C4CC;cursor:not-allowed;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:9px;border:1.5px solid #E8EAED;background:#fff;color:#3C4048;text-decoration:none;transition:.15s;" onmouseover="this.style.background='#F0F2F5';this.style.borderColor='#D8DBE0'" onmouseout="this.style.background='#fff';this.style.borderColor='#E8EAED'">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </a>
    @endif

    {{-- Page numbers --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:9px;border:1.5px solid #E8EAED;background:#fff;color:#8A909A;font-size:.82rem;font-weight:700;">…</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span aria-current="page" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:9px;border:1.5px solid #D4B800;background:#F5EFC0;color:#7A5C00;font-size:.82rem;font-weight:800;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:9px;border:1.5px solid #E8EAED;background:#fff;color:#3C4048;font-size:.82rem;font-weight:700;text-decoration:none;transition:.15s;" onmouseover="this.style.background='#F0F2F5';this.style.borderColor='#D8DBE0'" onmouseout="this.style.background='#fff';this.style.borderColor='#E8EAED'">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next arrow --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:9px;border:1.5px solid #E8EAED;background:#fff;color:#3C4048;text-decoration:none;transition:.15s;" onmouseover="this.style.background='#F0F2F5';this.style.borderColor='#D8DBE0'" onmouseout="this.style.background='#fff';this.style.borderColor='#E8EAED'">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    @else
        <span style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:9px;border:1.5px solid #E8EAED;background:#F4F5F7;color:#C0C4CC;cursor:not-allowed;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </span>
    @endif

</nav>
@endif
