@if ($paginator->hasPages())
    <nav role="navigation" aria-label="pagination" class="mx-auto flex w-full justify-center mt-6">

        <ul class="flex flex-row items-center gap-1">

            {{-- Previous --}}
            <li>
                @if ($paginator->onFirstPage())
                    <span class="btn-ghost opacity-50 cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            stroke="currentColor" stroke-width="2" class="mr-1">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        <span class="hidden sm:inline">Previous</span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            stroke="currentColor" stroke-width="2" class="mr-1">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        <span class="hidden sm:inline">Previous</span>
                    </a>
                @endif
            </li>

            {{-- Current Page (Mobile Only) --}}
            <li class="sm:hidden">
                <span class="btn-icon-outline">
                    {{ $paginator->currentPage() }}
                </span>
            </li>

            {{-- Pagination Numbers (Desktop Only) --}}
            <div class="hidden sm:flex flex-row items-center gap-1">
                @foreach ($elements as $element)
                    {{-- "..." separator --}}
                    @if (is_string($element))
                        <li>
                            <div class="size-9 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="1" />
                                    <circle cx="19" cy="12" r="1" />
                                    <circle cx="5" cy="12" r="1" />
                                </svg>
                            </div>
                        </li>
                    @endif

                    {{-- Actual pagination --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            {{-- Current Page --}}
                            @if ($page == $paginator->currentPage())
                                <li>
                                    <a href="#" aria-current="page" class="btn-icon-outline">
                                        {{ $page }}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $url }}" class="btn-icon-ghost">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next --}}
            <li>
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="btn-ghost">
                        <span class="hidden sm:inline">Next</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            stroke="currentColor" stroke-width="2" class="ml-1">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                @else
                    <span class="btn-ghost opacity-50 cursor-not-allowed">
                        <span class="hidden sm:inline">Next</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            stroke="currentColor" stroke-width="2" class="ml-1">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </span>
                @endif
            </li>

        </ul>

    </nav>
@endif
