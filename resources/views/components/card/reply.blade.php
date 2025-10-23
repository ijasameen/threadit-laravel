@props(['reply', 'link'])

@php
    $link_class = ' hover:border-secondary cursor-pointer';
@endphp

<div {{ $attributes->merge(['class' => 'block relative']) }}>
    @if (isset($link))
        <a href="{{ $link }}" class="size-full absolute"></a>
    @endif
    @php
        $interval = date_diff($reply->created_at, new DateTime());
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
    <div class="flex justify-between">
        <div class=" text-left">
            <a href="#" class="hover:underline relative">{{ $reply->user->username }}</a> •
            <span class="text-sm">{{ $ago }}</span>
        </div>
        @auth
            @if (Auth::user()->id == $reply->user->id)
                <div class="dropdown inline-flex">
                    <button id="dropdown-menu-icon" type="button" class="dropdown-toggle relative" aria-haspopup="menu"
                        aria-expanded="false" aria-label="Dropdown">
                        <span class="icon-[tabler--dots] hover:text-secondary-content size-6"></span>
                    </button>
                    <ul class="border-2 border-base-200 dropdown-menu dropdown-open:opacity-100 hidden min-w-60"
                        role="menu" aria-orientation="vertical" aria-labelledby="dropdown-menu-icon">
                        <li>
                            <a href="#" class="dropdown-item" href="#">Edit</a>
                        </li>
                        <li>
                            <button type="submit" form="deleteReplyForm_{{ $reply->id }}"
                                class="dropdown-item">Delete</button>
                        </li>
                    </ul>
                </div>
            @endif
        @endauth
    </div>
    <a class="block mb-3" href="#">
        {{ $reply->body }}
    </a>
    <div class="flex gap-x-2">
        <div class="flex items-center relative">
            <button type="button"
                class="btn btn-soft btn-sm rounded-bl-full rounded-tl-full text-secondary-content pr-3">
                <span class="icon-[tabler--arrow-big-up] size-4"></span>
                <span>3</span>
            </button>
            <button type="button"
                class="btn btn-soft btn-sm rounded-br-full rounded-tr-full text-secondary-content pl-2">
                <span class="icon-[tabler--arrow-big-down] size-4"></span>
                <span>1</span>
            </button>
        </div>
        <button type="button" class="btn btn-soft btn-sm rounded-full text-secondary-content relative">
            <a href="{{ route('replies.show', ['username' => $reply->user->username, 'id' => $reply->id]) }}"
                class="icon-[tabler--message-circle] size-4"></a>
            <span>{{ count($reply->childReplies) }}</span>
        </button>
        <button type="button" class="btn btn-soft btn-sm rounded-full text-secondary-content relative">
            <span class="icon-[tabler--share-3] size-4"></span>
        </button>
    </div>
    @auth
        <form hidden id="deleteReplyForm_{{ $reply->id }}" method="POST" action="{{ route('replies.destroy') }}">
            @csrf
            @method('DELETE')
            <input name="id" type="text" hidden value="{{ $reply->id }}">
        </form>
    @endauth
</div>
