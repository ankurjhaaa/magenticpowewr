@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        <div class="flex items-center justify-between w-full">
            {{-- Mobile-only simple view --}}
            <div class="flex justify-between flex-1 sm:hidden gap-4">
                @if ($paginator->onFirstPage())
                    <span class="flex-1 bg-white/5 text-white/30 px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-center cursor-not-allowed rounded-none">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="flex-1 border border-white/20 text-white hover:bg-brand-500 hover:text-black hover:border-brand-500 transition-colors px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-center rounded-none">
                        {!! __('pagination.previous') !!}
                    </a>
                @endif

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="flex-1 border border-white/20 text-white hover:bg-brand-500 hover:text-black hover:border-brand-500 transition-colors px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-center rounded-none">
                        {!! __('pagination.next') !!}
                    </a>
                @else
                    <span class="flex-1 bg-white/5 text-white/30 px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-center cursor-not-allowed rounded-none">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </div>

            {{-- Desktop view --}}
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-[10px] text-white/40 uppercase tracking-widest font-mono">
                        Showing <span class="font-bold text-white">{{ $paginator->firstItem() }}</span> to <span class="font-bold text-white">{{ $paginator->lastItem() }}</span> of <span class="font-bold text-white">{{ $paginator->total() }}</span> Results
                    </p>
                </div>

                <div>
                    <span class="inline-flex gap-2">
                        {{-- Previous Page Link --}}
                        @if ($paginator->onFirstPage())
                            <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-white/5 text-white/30 cursor-not-allowed border border-white/5 text-sm" aria-hidden="true">&larr;</span>
                            </span>
                        @else
                            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center w-10 h-10 bg-black text-white hover:bg-brand-500 hover:text-black hover:border-brand-500 border border-white/20 transition-colors text-sm" aria-label="{{ __('pagination.previous') }}">&larr;</a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span aria-disabled="true">
                                    <span class="inline-flex items-center justify-center w-10 h-10 bg-transparent text-white/40 text-xs border border-transparent font-mono cursor-default">{{ $element }}</span>
                                </span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <span aria-current="page">
                                            <span class="inline-flex items-center justify-center w-10 h-10 bg-brand-500 text-black border border-brand-500 font-bold text-xs cursor-default">{{ $page }}</span>
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="inline-flex items-center justify-center w-10 h-10 bg-black text-white hover:bg-white/10 border border-white/20 transition-colors font-bold text-xs" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center w-10 h-10 bg-black text-white hover:bg-brand-500 hover:text-black hover:border-brand-500 border border-white/20 transition-colors text-sm" aria-label="{{ __('pagination.next') }}">&rarr;</a>
                        @else
                            <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-white/5 text-white/30 cursor-not-allowed border border-white/5 text-sm" aria-hidden="true">&rarr;</span>
                            </span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </nav>
@endif
