@if ($paginator->hasPages())
<style>
    .custom-pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }
    .custom-pagination .pagination-info {
        font-size: 14px;
        color: #64748b;
    }
    .custom-pagination .pagination-info strong {
        color: #334155;
        font-weight: 600;
    }
    .custom-pagination .pagination-links {
        display: flex;
        align-items: center;
        gap: 6px;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .custom-pagination .page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 14px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 2px solid transparent;
    }
    .custom-pagination .page-btn.nav-btn {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        gap: 6px;
    }
    .custom-pagination .page-btn.nav-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    .custom-pagination .page-btn.nav-btn.disabled {
        background: #e2e8f0;
        color: #94a3b8;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    .custom-pagination .page-btn.number {
        background: #fff;
        color: #475569;
        border-color: #e2e8f0;
    }
    .custom-pagination .page-btn.number:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    .custom-pagination .page-btn.number.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        border-color: transparent;
    }
    .custom-pagination .page-btn.dots {
        background: transparent;
        color: #94a3b8;
        cursor: default;
        min-width: 30px;
        padding: 0;
    }
    @media (max-width: 640px) {
        .custom-pagination {
            justify-content: center;
        }
        .custom-pagination .pagination-info {
            width: 100%;
            text-align: center;
        }
    }
</style>
<nav class="custom-pagination">
    <div class="pagination-info">
        Menampilkan <strong>{{ $paginator->firstItem() }}</strong> - <strong>{{ $paginator->lastItem() }}</strong> dari <strong>{{ $paginator->total() }}</strong> data
    </div>
    <ul class="pagination-links">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li>
                <span class="page-btn nav-btn disabled">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Previous
                </span>
            </li>
        @else
            <li>
                <a class="page-btn nav-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Previous
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li><span class="page-btn dots">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><span class="page-btn number active">{{ $page }}</span></li>
                    @else
                        <li><a class="page-btn number" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a class="page-btn nav-btn" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    Next
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </li>
        @else
            <li>
                <span class="page-btn nav-btn disabled">
                    Next
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            </li>
        @endif
    </ul>
</nav>
@endif
