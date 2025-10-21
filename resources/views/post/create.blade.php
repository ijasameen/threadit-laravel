<x-layout.app>
    <h2 class="text-base-content text-3xl mb-6">New post</h2>
    <form method="POST" action="/u/{{ $user->username }}/posts" class="flex flex-col gap-2">
        @csrf

        <div>
            <x-form.label for="summary">Summary</x-form.label>
            <x-form.text-area name="summary" id="summary" autocomplete='summary' placeholder="Say something"
                :value="old('summary')" />
            <x-form.error :messages="$errors->get('summary')" />
        </div>
        <div>
            <x-form.label for="body">Body</x-form.label>
            <x-form.text-area name="body" id="body" autocomplete='body' placeholder="If you need more words"
                :value="old('body')" rows=12 />
            <x-form.error :messages="$errors->get('body')" />
        </div>
        <div class="flex items-center gap-1">
            <input type="checkbox" name="is_publish" id="isPublish" class="switch switch-primary" checked
                onchange="onIsPublishChanged(this)" />
            <label class="label-text text-base" id="isPublishLabel" for="isPublish">Publish</label>
        </div>
        <div class="ml-auto">
            <button type="submit" id="formSubmitBtn" class="btn btn-primary">Post</button>
        </div>
    </form>
</x-layout.app>

<script>
    function onIsPublishChanged(element) {
        document.getElementById('isPublishLabel').textContent = element.checked ? 'Publish' : 'Draft';
        document.getElementById('formSubmitBtn').textContent = element.checked ? 'Post' : 'Save as Draft';
    }
</script>
