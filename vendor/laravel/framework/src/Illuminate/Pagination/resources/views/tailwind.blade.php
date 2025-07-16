@if ($paginator->hasPages())
    <div class="flex flex-col items-center mt-4 gap-2">
        <p class="text-sm text-gray-700 dark:text-gray-400 mb-2">
            {!! __('Showing') !!}
            @if ($paginator->firstItem())
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
            @else
                {{ $paginator->count() }}
            @endif
            {!! __('of') !!}
            <span class="font-medium">{{ $paginator->total() }}</span>
            {!! __('results') !!}
        </p>
        <nav class="flex items-center space-x-1">
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-md cursor-default select-none">Prev</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-blue-600 bg-white border border-gray-200 rounded-md hover:bg-blue-50">Prev</a>
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

            {{-- DEBUG --}}
            {{-- <p>DEBUG: current={{ $current }} start={{ $start }} end={{ $end }}</p> --}}

            @if ($start > 1)
                <a href="{{ $paginator->url(1) }}" class="px-3 py-2 text-blue-600 bg-white border border-gray-200 rounded-md hover:bg-blue-50">1</a>
                @if ($start > 2)
                    <span class="px-2 text-gray-400 select-none">...</span>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $current)
                    <span class="px-3 py-2 bg-blue-600 text-white rounded-md border border-blue-600 font-bold cursor-default">{{ $i }}</span>
                @else
                    <a href="{{ $paginator->url($i) }}" class="px-3 py-2 text-blue-600 bg-white border border-gray-200 rounded-md hover:bg-blue-50">{{ $i }}</a>
                @endif
            @endfor

            @if ($end < $total)
                @if ($end < $total - 1)
                    <span class="px-2 text-gray-400 select-none">...</span>
                @endif
                <a href="{{ $paginator->url($total) }}" class="px-3 py-2 text-blue-600 bg-white border border-gray-200 rounded-md hover:bg-blue-50">{{ $total }}</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-blue-600 bg-white border border-gray-200 rounded-md hover:bg-blue-50">Next</a>
            @else
                <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-md cursor-default select-none">Next</span>
            @endif
        </nav>
    </div>
@endif
