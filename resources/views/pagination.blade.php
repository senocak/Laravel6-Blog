<style>
    .pagination {
        display: inline-block;
    }
    .pagination a {
        color: white;
        padding: 8px 16px;
        text-decoration: none;
    }

    .pagination a.active {
        background-color: #252627;
        color: white;
    }
    .pagination a:hover:not(.active) {
        background-color: #252627;
    }
</style>
@if ($paginator->hasPages())
    <div class="pagination">
        @if ($paginator->onFirstPage())
            <a><span>&laquo;</span></a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <a><span>{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="active"><span>{{ $page }}</span></a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
        @else
            <a class="disabled"><span>&raquo;</span></a>
        @endif
    </div>
@endif
