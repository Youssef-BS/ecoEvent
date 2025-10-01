@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="d-flex justify-content-center">
        <ul class="pagination gap-3 mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="Précédent">
                    <span
                        class="page-link rounded-pill px-4 py-2 border border-2 border-primary text-primary fw-semibold bg-white">
                        &#8249; Précédent
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-pill px-4 py-2 border border-2 border-primary text-primary fw-semibold bg-white"
                        href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Précédent">
                        &#8249; Précédent
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span
                            class="page-link rounded-pill px-4 py-2 border-0 text-muted bg-white">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span
                                    class="page-link rounded-pill px-4 py-2 border border-2 border-primary bg-light text-primary fw-semibold">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item"><a
                                    class="page-link rounded-pill px-4 py-2 border border-2 border-primary text-primary fw-semibold bg-white"
                                    href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-pill px-4 py-2 border border-2 border-primary text-primary fw-semibold bg-white"
                        href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Suivant">
                        Suivant &#8250;
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="Suivant">
                    <span
                        class="page-link rounded-pill px-4 py-2 border border-2 border-primary text-primary fw-semibold bg-white">
                        Suivant &#8250;
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
