@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="border-2 border-[#111111] bg-white p-3">
        <div class="flex items-center justify-between gap-3 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center justify-center min-h-[44px] px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#525252] bg-[#F4F4F4] border-2 border-[#111111] cursor-not-allowed">
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center min-h-[44px] px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#111111] bg-white border-2 border-[#111111] hover:bg-[#FFFF00] transition-colors">
                    &larr; Sebelumnya
                </a>
            @endif

            <span class="font-mono text-xs font-bold text-[#111111]">
                Hal {{ $paginator->currentPage() }}/{{ $paginator->lastPage() }}
            </span>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center min-h-[44px] px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#000000] bg-[#FF0000] border-2 border-[#111111] hover:bg-[#EB0000] transition-colors">
                    Berikutnya &rarr;
                </a>
            @else
                <span class="inline-flex items-center justify-center min-h-[44px] px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#525252] bg-[#F4F4F4] border-2 border-[#111111] cursor-not-allowed">
                    Berikutnya
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-wrap sm:items-center sm:justify-between gap-4">
            <p class="text-xs font-medium text-[#525252]">
                Menampilkan
                @if ($paginator->firstItem())
                    <span class="font-mono font-bold text-[#111111]">{{ $paginator->firstItem() }}</span>
                    -
                    <span class="font-mono font-bold text-[#111111]">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                dari
                <span class="font-mono font-bold text-[#111111]">{{ $paginator->total() }}</span>
                data
            </p>

            <div class="inline-flex items-stretch border-2 border-[#111111] bg-[#111111] gap-[2px]">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="Halaman sebelumnya" class="inline-flex items-center justify-center min-w-[44px] min-h-[44px] px-3 text-xs font-bold bg-[#F4F4F4] text-[#525252] cursor-not-allowed">
                        <i class="fa-solid fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya" class="inline-flex items-center justify-center min-w-[44px] min-h-[44px] px-3 text-xs font-bold bg-white text-[#111111] hover:bg-[#FFFF00] transition-colors">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span aria-disabled="true" class="inline-flex items-center justify-center min-w-[44px] min-h-[44px] px-3 text-xs font-mono font-bold bg-white text-[#525252]">
                            {{ $element }}
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="inline-flex items-center justify-center min-w-[44px] min-h-[44px] px-3.5 text-xs font-mono font-bold bg-[#0000FF] text-white cursor-default">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" aria-label="Ke halaman {{ $page }}" class="inline-flex items-center justify-center min-w-[44px] min-h-[44px] px-3.5 text-xs font-mono font-bold bg-white text-[#111111] hover:bg-[#FFFF00] transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya" class="inline-flex items-center justify-center min-w-[44px] min-h-[44px] px-3 text-xs font-bold bg-white text-[#111111] hover:bg-[#FFFF00] transition-colors">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="Halaman berikutnya" class="inline-flex items-center justify-center min-w-[44px] min-h-[44px] px-3 text-xs font-bold bg-[#F4F4F4] text-[#525252] cursor-not-allowed">
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
