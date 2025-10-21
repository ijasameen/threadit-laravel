<x-layout.html>

    <body class='min-h-screen bg-base-200 p-3'>
        <div class="max-w-[1440px] mx-auto flex relative">
            <div class="fixed max-w-[1440px] w-full flex justify-between pointer-events-none">
                <aside class="w-68 invisible md:visible space-y-3 pointer-events-auto">
                    <div class="card">
                        <a href="/" class="cursor-pointer p-3 text-base-content font-bold">Threadit</a>
                    </div>
                    <div class="card">
                        <ul class="menu">
                            <li class="menu-title">{{ Auth::user()->name ?? 'Guest' }}</li>
                            @auth
                                <li>
                                    <a href="#">
                                        <span class="icon-[tabler--user] size-5"></span>
                                        Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="icon-[tabler--settings] size-5"></span>
                                        Preferences
                                    </a>
                                </li>
                                <li>
                                    <button type="submit" form="logoutForm" class="btn btn-outline">
                                        <span class="icon-[tabler--logout] size-5"></span>
                                        Log Out
                                    </button>
                                </li>
                            @endauth
                            @guest
                                <li class="flex gap-2">
                                    <a href="{{ route('login') }}" class="btn btn-outline">
                                        <span class="icon-[tabler--login] size-5"></span>
                                        Log in
                                    </a>
                                    <a href="{{ route('signup') }}" class="btn btn-outline">
                                        <span class="icon-[tabler--user-plus] size-5"></span>
                                        Sign up
                                    </a>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </aside>

                <aside class="w-60 hidden lg:block pointer-events-auto">
                    {{ $aside ?? '' }}
                </aside>
            </div>

            <main class="flex-1 w-full px-4 md:ml-[272px] lg:mr-[240px]
                flex flex-col">
                <div class="w-full max-w-xl mx-auto flex justify-between mb-4
                    md:hidden">
                    <div class="card">
                        <a href="/" class="cursor-pointer p-3 text-base-content font-bold">Threadit</a>
                    </div>
                    @auth
                        <div class="dropdown relative inline-flex [--auto-close:inside]">
                            <button id="dropdown-name" type="button"
                                class="dropdown-toggle btn btn-text btn-circle dropdown-open:bg-base-content/10
                                    dropdown-open:text-base-content p-2 size-11"
                                aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                <span class="icon-[tabler--menu-2] size-8"></span>
                            </button>
                            <ul class="border-2 border-base-200 dropdown-menu dropdown-open:opacity-100 hidden"
                                role="menu" aria-orientation="vertical" aria-labelledby="dropdown-name">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Preferences</a></li>
                                <li><button form="logoutForm" class="dropdown-item" href="#">Log Out</button></li>
                            </ul>
                        </div>
                    @endauth
                    @guest
                        <div class="space-x-2">
                            <a href="{{ route('login') }}" class="btn btn-outline">
                                <span class="icon-[tabler--login] size-5"></span>
                                Log in
                            </a>
                            <a href="{{ route('signup') }}" class="btn btn-outline">
                                <span class="icon-[tabler--user-plus] size-5"></span>
                                Sign up
                            </a>
                        </div>
                    @endguest
                </div>

                <div class="w-full max-w-xl mx-auto">
                    {{ $slot }}
                </div>
            </main>

            <form id="logoutForm" method="POST" action="/logout" class="hidden">
                @csrf
            </form>
        </div>
    </body>

</x-layout.html>
