@if ($paginator->hasPages())
    <nav class=" nav__pagination">
        {{-- Previous Page Link --}}
        <div class="nav__pagination_previous">
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span aria-hidden="true"></span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTQiIGhlaWdodD0iMTQiIHZpZXdCb3g9IjAgMCAxNCAxNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyLjgzMzIgNi45OTk5NkgxLjE2NjVNMS4xNjY1IDYuOTk5OTZMNi45OTk4NCAxMi44MzMzTTEuMTY2NSA2Ljk5OTk2TDYuOTk5ODQgMS4xNjY2MyIgc3Ryb2tlPSIjNjY3MDg1IiBzdHJva2Utd2lkdGg9IjEuNjciIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K"  alt="prev" />
                    <i>{{ __('Назад') }}</i></a>
            </li>
        @endif
        </div>
        <ul class="pagination">

        @if($paginator->currentPage() > 3)
            <li class="hidden-xs"><a href="{{ $paginator->url(1) }}">1</a></li>
        @endif
        @if($paginator->currentPage() > 4)
            <li><span>...</span></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li><span>...</span></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="hidden-xs"><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif
</ul>
        {{-- Next Page Link --}}
        <div class="nav__pagination_next">

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <i>{{ __('Вперед') }}</i> <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTQiIGhlaWdodD0iMTQiIHZpZXdCb3g9IjAgMCAxNCAxNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEuMTY2ODMgNi45OTk5NkgxMi44MzM1TTEyLjgzMzUgNi45OTk5Nkw3LjAwMDE2IDEyLjgzMzNNMTIuODMzNSA2Ljk5OTk2TDcuMDAwMTYgMS4xNjY2MyIgc3Ryb2tlPSIjNjY3MDg1IiBzdHJva2Utd2lkdGg9IjEuNjciIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K"  alt="next" /></a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true"></span>
                </li>
            @endif
        </div>
    </nav>
@endif






