<x-layout.app>
    @auth
        <div class="w-fit mx-auto">
            <a href="{{ route('posts.create', ['username' => $user->username]) }}"
                class="btn btn-lg text-base w-8/12 min-w-60 md:btn-md lg:hidden rounded-full mb-3">
                <span class="icon-[tabler--pencil-plus] size-5"></span>
                <span>Post something</span>
            </a>
        </div>
    @endauth

    <div class="w-fit mx-auto">
        @foreach ($posts as $post)
            <x-post-card :$post :$user />
        @endforeach
    </div>

    <x-slot:aside>
        @auth
            <a href="{{ route('posts.create', ['username' => $user->username]) }}" class="btn rounded-full mb-3 w-fit">
                <span class="icon-[tabler--pencil-plus] size-5"></span>
                <span>Post something</span>
            </a>
        @endauth
    </x-slot>
</x-layout.app>
