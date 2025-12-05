@if ($paginator->hasPages())
<nav class="pagination">
    {{-- 前へ --}}
    @if ($paginator->onFirstPage())
        <span class="pagination__item pagination__disabled">&lt;</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="pagination__item">&lt;</a>
    @endif


    {{-- ページ番号 --}}
    @foreach ($elements as $element)

        @if (is_string($element))
            <span class="pagination__item">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)

                @if ($page == $paginator->currentPage())
                    <span class="pagination__item pagination__active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pagination__item">{{ $page }}</a>
                @endif

            @endforeach
        @endif

    @endforeach


    {{-- 次へ --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="pagination__item">&gt;</a>
    @else
        <span class="pagination__item pagination__disabled">&gt;</span>
    @endif
</nav>
@endif
