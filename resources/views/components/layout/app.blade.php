<x-layout.html>

    <body class='min-h-screen bg-base-200 flex p-3'>
        <aside class="w-fit">
            <div class="card w-80">
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

        <main class="flex-1 px-4">
            {{ $slot }}
        </main>
    </body>

</x-layout.html>
