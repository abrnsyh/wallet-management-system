<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Balance - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@php
    $links = [['title' => 'dashboard', 'href' => route('dashboard')]];
@endphp

<body>
    <aside id="sidebar" class="sidebar" data-side="left" aria-hidden="false">
        <nav aria-label="Sidebar navigation">
            <header>
                <a href="{{ route('dashboard') }}" class="btn-ghost p-2 h-12 w-full justify-start">Logo</a>
            </header>
            <section class="scrollbar">
                <div role="group" aria-labelledby="group-label-content-1">
                    <h3 id="group-label-content-1">Main Feature</h3>
                    <ul>
                        @foreach ($links as $link)
                            <li>
                                <a href="{{ $link['href'] }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m7 11 2-2-2-2" />
                                        <path d="M11 13h4" />
                                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                                    </svg>
                                    <span>{{ ucfirst($link['title']) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
            <footer>
                <div id="demo-dropdown-menu" class="dropdown-menu">
                    <button type="button" id="demo-dropdown-menu-trigger" aria-haspopup="menu"
                        aria-controls="demo-dropdown-menu-menu" aria-expanded="false"
                        class="btn-outline p-2 h-12 flex items-center justify-start w-full"
                        data-keep-mobile-sidebar-open>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-8" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-user-round-icon lucide-circle-user-round">
                            <path d="M18 20a6 6 0 0 0-12 0" />
                            <circle cx="12" cy="10" r="4" />
                            <circle cx="12" cy="12" r="10" />
                        </svg>
                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-medium">{{ ucfirst(Auth::user()->name) }}</span>
                            <span class="truncate text-xs">{{ Auth::user()->email }}</span>
                        </div>

                    </button>
                    <div id="demo-dropdown-menu-popover" data-side="top" data-popover aria-hidden="true"
                        class="w-[271px] md:w-[239px]">
                        <div role="menu" id="demo-dropdown-menu-menu" aria-labelledby="demo-dropdown-menu-trigger">
                            <div role="group" aria-labelledby="account-options">
                                <div role="heading" id="account-options">My Account</div>
                                <button form="logoutForm" type="submit" role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-log-out-icon lucide-log-out">
                                        <path d="m16 17 5-5-5-5" />
                                        <path d="M21 12H9" />
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    </svg>
                                    Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </nav>
    </aside>

    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>

    <div>
        <div class="flex items-center justify-between w-full h-14 border px-4">
            {{-- Sidebar Button --}}
            <button type="button" aria-label="Toggle sidebar" data-tooltip="Toggle sidebar" data-side="bottom"
                data-align="start" class="btn-sm-icon-ghost"
                onclick="document.dispatchEvent(new CustomEvent('basecoat:sidebar'));">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-panel-left-icon lucide-panel-left">
                    <rect width="18" height="18" x="3" y="3" rx="2" />
                    <path d="M9 3v18" />
                </svg>
            </button>
            {{-- End of Sidebar Button --}}

            {{-- Right Side Button --}}
            <button type="button" data-align="end" aria-label="Toggle dark mode" data-tooltip="Toggle dark mode"
                data-side="bottom" onclick="document.dispatchEvent(new CustomEvent('basecoat:theme'))"
                class="btn-icon-outline size-8">
                <span class="hidden dark:block"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="4" />
                        <path d="M12 2v2" />
                        <path d="M12 20v2" />
                        <path d="m4.93 4.93 1.41 1.41" />
                        <path d="m17.66 17.66 1.41 1.41" />
                        <path d="M2 12h2" />
                        <path d="M20 12h2" />
                        <path d="m6.34 17.66-1.41 1.41" />
                        <path d="m19.07 4.93-1.41 1.41" />
                    </svg></span>
                <span class="block dark:hidden"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" />
                    </svg></span>
            </button>
            {{-- End of Right Side Button --}}

        </div>


        <main>
            @yield('content')
        </main>
    </div>


    <script>
        (() => {
            try {
                const stored = localStorage.getItem('themeMode');
                if (stored ? stored === 'dark' :
                    matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.classList.add('dark');
                }
            } catch (_) {}

            const apply = dark => {
                document.documentElement.classList.toggle('dark', dark);
                try {
                    localStorage.setItem('themeMode', dark ? 'dark' : 'light');
                } catch (_) {}
            };

            document.addEventListener('basecoat:theme', (event) => {
                const mode = event.detail?.mode;
                apply(mode === 'dark' ? true :
                    mode === 'light' ? false :
                    !document.documentElement.classList.contains('dark'));
            });
        })();
    </script>
    @stack('customJs')
</body>

</html>
