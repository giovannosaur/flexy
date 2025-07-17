@if ($paginator->hasPages())
    <div class="d-flex flex-column align-items-center mt-4 gap-2">
        <p class="text-sm text-gray-700 mb-2">
            Showing
            @if ($paginator->firstItem())
                <span class="fw-normal">{{ $paginator->firstItem() }}</span>
                to
                <span class="fw-normal">{{ $paginator->lastItem() }}</span>
            @else
                {{ $paginator->count() }}
            @endif
            of
            <span class="fw-normal">{{ $paginator->total() }}</span>
            results
        </p>
        <nav>
            <ul class="pagination justify-content-center mb-0">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Prev</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}">Prev</a>
                    </li>
                @endif

                @php
                    $total = $paginator->lastPage();
                    $current = $paginator->currentPage();
                    $start = max(1, $current - 2);
                    $end = min($total, $start + 4);
                    if($end - $start < 4){
                        $start = max(1, $end - 4);
                    }
                @endphp

                @if ($start > 1)
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
                    @if ($start > 2)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $current)
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{ $i }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endfor

                @if ($end < $total)
                    @if ($end < $total - 1)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url($total) }}">{{ $total }}</a></li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Next</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
