<x-layout.app>
    @foreach ($posts as $post)
        <x-post-card :$post />
    @endforeach
</x-layout.app>
