<x-layout.html>

    <body class='min-h-screen bg-base-200 p-3'>
        <div class="max-w-[1440px] mx-auto flex">
            <aside class="w-72 fixed lg:w-80 invisible md:visible">
                <div class="card">
                    <ul class="menu">
                        <li class="menu-title">{{ Auth::user()->name ?? 'Guest' }}</li>
                        @auth
                            <li>
                                <a href="#" class="menu-active">
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
                        @endauth
                    </ul>
                    @auth
                        <form method="POST" action="/logout" class="px-6 pb-6">
                            @csrf

                            <button type="submit" class="btn btn-outline">
                                <span class="icon-[tabler--logout] size-5"></span>
                                Log Out
                            </button>
                        </form>
                    @endauth
                    @guest
                        <div class="px-6 pb-6 space-x-2">
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
            </aside>

            <main class="flex-1 px-4 md:ml-[288px] lg:ml-[320px] xl:mr-[280px]">
                {{ $slot }}
            </main>

            <aside class="fixed w-0 xl:w-70">
            </aside>
        </div>
    </body>

</x-layout.html>
