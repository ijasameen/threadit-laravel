@props(['post', 'back_url'])

<div class="card w-full bg-base-200 border-1 border-neutral mb-4">
    <div class="card-body">
        @php
            $interval = date_diff($post->published_at, new DateTime());
            $units = [
                'y' => 'year',
                'm' => 'month',
                'd' => 'day',
                'h' => 'hour',
                'i' => 'minute',
                's' => 'second',
            ];

            foreach ($units as $prop => $label) {
                if ($interval->$prop > 0) {
                    $count = $interval->$prop;
                    $ago = "$count $label" . ($count > 1 ? 's' : '') . ' ago';
                    break;
                }
            }

            $ago ??= 'just now';
        @endphp
        <div class="flex justify-between mb-3">
            <div class=" text-left">
                <div class="btn btn-circle btn-outline size-9">
                    <a href="{{ $back_url }}" class="size-6 icon-[tabler--arrow-left]"></a>
                </div>
                <a href="#" class="ml-2 hover:underline">{{ $post->user->username }}</a> •
                <span class="text-sm">{{ $ago }}</span>
                @if ($post->isPrivate())
                    <span class="ml-0.5 text-xs font-bold bg-base-200 py-1 px-2 rounded-full">Private</span>
                @endif
            </div>
            @auth
                @if (Auth::user()->id == $post->user->id)
                    <div class="dropdown inline-flex">
                        <button id="dropdown-menu-icon" type="button" class="dropdown-toggle" aria-haspopup="menu"
                            aria-expanded="false" aria-label="Dropdown">
                            <span class="icon-[tabler--dots] hover:text-secondary-content size-6"></span>
                        </button>
                        <ul class="border-2 border-base-200 dropdown-menu dropdown-open:opacity-100 hidden min-w-60"
                            role="menu" aria-orientation="vertical" aria-labelledby="dropdown-menu-icon">
                            <li>
                                <a href="{{ route('posts.edit', ['username' => Auth::user()->username, 'id' => $post->id, 'slug' => $post->slug]) }}"
                                    class="dropdown-item" href="#">Edit</a>
                            </li>
                            <li><button type="submit" form="deleteForm_{{ $post->id }}"
                                    class="dropdown-item">Delete</button></li>
                        </ul>
                    </div>
                @endif
            @endauth
        </div>
        <h2 class="text-base-content text-3xl mb-3">{{ $post->summary }}</h2>
        <p class="mb-4">{{ $post->body }}</p>
        <div class="flex gap-x-2">
            <div class="flex items-center">
                <button type="button" class="btn btn-soft rounded-bl-full rounded-tl-full text-secondary-content pr-3">
                    <span class="icon-[tabler--arrow-big-up] size-5"></span>
                    <span>3</span>
                </button>
                <button type="button" class="btn btn-soft rounded-br-full rounded-tr-full text-secondary-content pl-2">
                    <span class="icon-[tabler--arrow-big-down] size-5"></span>
                    <span>3</span>
                </button>
            </div>
            <button type="button" class="btn btn-soft rounded-full text-secondary-content">
                <span class="icon-[tabler--message-circle] size-5"></span>
                <span>3</span>
            </button>
            <button type="button" class="btn btn-soft rounded-full text-secondary-content">
                <span class="icon-[tabler--bookmark] size-5"></span>
            </button>
            <button type="button" class="btn btn-soft rounded-full text-secondary-content">
                <span class="icon-[tabler--share-3] size-5"></span>
            </button>
        </div>
    </div>
    @auth
        <form hidden id="deleteForm_{{ $post->id }}" method="POST" action="{{ route('posts.destroy') }}">
            @csrf
            @method('DELETE')
            <input name="id" type="text" hidden value="{{ $post->id }}">
        </form>
    @endauth
</div>
