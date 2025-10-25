<x-layout.app>
    <h2 class="text-base-content text-3xl mb-6">Edit post</h2>
    <form method="POST" action="{{ route('posts.update') }}" class="flex flex-col
        gap-2">
        @csrf
        @method('PATCH')

        <input hidden type="text" name="id" value="{{ $post->id }}">
        <div>
            <x-form.label for="summary">Summary</x-form.label>
            <x-form.text-area name="summary" id="summary" autocomplete='summary' placeholder="Say something"
                :value="$post->summary" />
            <x-form.error :messages="$errors->get('summary')" />
        </div>
        <div>
            <x-form.label for="body">Body</x-form.label>
            <x-form.text-area name="body" id="body" autocomplete='body' placeholder="If you need more words"
                :value="$post->body" rows=12 class="min-h-60" />
            <x-form.error :messages="$errors->get('body')" />
        </div>
        <div class="flex items-center gap-1">
            <input type="checkbox" name="is_public" id="isPublic" class="switch switch-primary"
                {{ $post->isPublic() ? 'checked' : '' }} onchange="onIsPublicChanged(this)" />
            <label class="label-text text-base" id="isPublicLabel"
                for="isPublic">{{ $post->visibility->label() }}</label>
        </div>
        <div class="ml-auto">
            <button type="submit" id="formSubmitBtn" class="btn btn-primary">Save</button>
            <a href="{{ $cancel_url }}" class="btn btn-error btn-soft">Cancel</a>
        </div>
    </form>
</x-layout.app>

<script>
    function onIsPublicChanged(element) {
        document.getElementById('isPublicLabel').textContent = element.checked ? 'Public' : 'Private';
    }
</script>
