@if ($paginator->hasPages())
<nav>
    <ul class="pagination">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" tabindex="-1" aria-disabled="true">
                    <em class="icon ni ni-chevrons-left"></em>
                    <span>Trước</span>

                </a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                    <em class="icon ni ni-chevrons-left"></em>
                    <span>Trước</span>

                </a>
            </li>
        @endif
      
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled">{{ $element }}</li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <a class="page-link">{{ $page }}</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach
        
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    <span>Sau</span>
                    <em class="icon ni ni-chevrons-right"></em>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" tabindex="-1" aria-disabled="true">
                    <span>Sau</span>
                    <em class="icon ni ni-chevrons-right"></em>
                </a>
            </li>
        @endif
    </ul>
@endif