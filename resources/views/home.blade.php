<x-layout.app>
    @auth
        <a href="#" class="btn btn-lg text-base w-8/12 min-w-60 md:btn-md lg:hidden rounded-full mb-3">
            <span class="icon-[tabler--pencil-plus] size-5"></span>
            <span>Post something</span>
        </a>
    @endauth

    @foreach ($posts as $post)
        <x-post-card :$post />
    @endforeach

    <x-slot:aside>
        @auth
            <a href="#" class="btn rounded-full mb-3 w-fit">
                <span class="icon-[tabler--pencil-plus] size-5"></span>
                <span>Post something</span>
            </a>
        @endauth
    </x-slot>
</x-layout.app>
