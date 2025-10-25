@php
    $user = auth()->user();
@endphp

<x-layout.app>
    <div class="w-full max-w-3xl mx-auto ">
        <x-card.post-full :$post :$user :$back_url />
        <div>
            @auth
                <form method="POST" action="{{ route('replies.store') }}" class="mx-5 mb-3 space-y-2 flex flex-col">
                    @csrf

                    <div>
                        <input name="post_id" type="text" hidden value="{{ $post->id }}">
                        <x-form.text-area name="body" id="body" autocomplete='body' placeholder="Reply"
                            :value="old('body')" rows=3 />
                        <x-form.error :messages="$errors->get('body')" />
                    </div>

                    <button type="submit" class="btn btn-primary self-end w-full max-w-28">Reply</button>
                </form>
            @endauth
            <x-list.replies>
                @foreach ($replies as $reply)
                    <x-list.item.reply :$reply :$user />
                @endforeach
            </x-list.replies>
        </div>
    </div>
</x-layout.app>
