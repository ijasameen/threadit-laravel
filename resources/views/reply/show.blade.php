@php
    $post = $reply->post;
@endphp

<x-layout.app>
    <div class="w-full max-w-3xl mx-auto space-y-3">
        <div>
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
                                    <a href="{{ route('posts.edit', ['username' => Auth::user()->username, 'post' => $post->id, 'slug' => $post->slug]) }}"
                                        class="dropdown-item" href="#">Edit</a>
                                </li>
                                <li><button type="submit" form="deleteForm_{{ $post->id }}"
                                        class="dropdown-item">Delete</button></li>
                            </ul>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
        <button type="button" class="flex gap-2 items-center collapse-toggle" id="basic-collapse" aria-expanded="false"
            aria-controls="basic-collapse-heading" data-collapse="#basic-collapse-heading">
            <h2 class="text-base-content text-3xl mb-3">{{ $post->summary }}</h2>
            <div
                class="size-8 flex justify-center items-center rounded-full hover:bg-base-100 collapse-open:rotate-180">
                <span class="icon-[tabler--chevron-down] size-6"></span>
            </div>
        </button>
        <div id="basic-collapse-heading" class="collapse hidden w-full overflow-hidden transition-[height] duration-300"
            aria-labelledby="basic-collapse">
            <p class="mb-4">{{ $post->body }}</p>
            <div class="flex gap-x-2 mb-3">
                <div class="flex items-center">
                    <button type="button" data-vote="up" data-votable-type="post" data-votable-id="{{ $post->id }}"
                        class="vote-btn btn btn-soft rounded-bl-full rounded-tl-full text-secondary-content pr-3">
                        <span id="post_{{ $post->id }}_upvote-indicator"
                            {{ $post->getVoteForUser($user)?->value > 0 ? 'data-fill' : '' ?? '' }}
                            class="data-[fill]:icon-[tabler--arrow-big-up-filled] data-[fill]:size-5 pointer-events-none icon-[tabler--arrow-big-up] size-5"></span>
                        <span id="post_{{ $post->id }}_upvotes"
                            class="pointer-events-none">{{ $post->upVotes() }}</span>
                    </button>
                    <button type="button" data-vote="down" data-votable-type="post"
                        data-votable-id="{{ $post->id }}"
                        class="vote-btn btn btn-soft rounded-br-full rounded-tr-full text-secondary-content pl-2">
                        <span id="post_{{ $post->id }}_downvote-indicator"
                            {{ $post->getVoteForUser($user)?->value < 0 ? 'data-fill' : '' ?? '' }}
                            class="data-[fill]:icon-[tabler--arrow-big-down-filled] data-[fill]:size-5 pointer-events-none icon-[tabler--arrow-big-down] size-5"></span>
                        <span id="post_{{ $post->id }}_downvotes"
                            class="pointer-events-none">{{ $post->downVotes() }}</span>
                    </button>
                </div>
                <button type="button" class="btn btn-soft rounded-full text-secondary-content">
                    <span class="icon-[tabler--message-circle] size-5"></span>
                    <span>3</span>
                </button>
                <button type="button" {{ $user?->isSavedPost($post) ? 'data-saved="on"' : '' }}
                    data-savable-type="post" data-savable-id="{{ $post->id }}"
                    class="btn btn-soft save-btn rounded-full text-secondary-content relative">
                    <span id="post_{{ $post->id }}_save-indicator"
                        {{ $post->isSavedByUser($user) ? 'data-fill' : '' }}
                        class="data-[fill]:icon-[tabler--bookmark-filled] data-[fill]:size-5 pointer-events-none icon-[tabler--bookmark] size-5"></span>
                </button>
                <button type="button" class="btn btn-soft rounded-full text-secondary-content">
                    <span class="icon-[tabler--share-3] size-5"></span>
                </button>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ $back_url }}" class="btn btn-circle btn-outline size-9">
                <span class="size-6 icon-[tabler--arrow-left]"></span>
            </a>
            <a href="{{ route('posts.show', ['username' => $post->user->username, 'post' => $post->id, 'slug' => $post->slug]) }}"
                class="btn btn-outline">Go to post</a>
        </div>
        @php
            $parent_reply = $reply->parentReply;
            $parent_replies = [];
            while ($parent_reply !== null) {
                $parent_replies[] = $parent_reply;
                $parent_reply = $parent_reply->parentReply;
            }
            $parent_replies = array_reverse($parent_replies);
        @endphp
        @foreach ($parent_replies as $parent_reply)
            <ul class="menu">
                <li>
                    <x-card.reply :reply="$parent_reply" :$user />
                </li>
                <ul class="menu">
        @endforeach
        @if (!empty($parent_replies))
            <li>
        @endif
        <x-card.reply class="bg-base-200 mb-4 p-6 rounded-lg" :$reply :$user :is-link="false" :border="true" />
        @if (!empty($parent_replies))
            </li>
        @endif
        @auth
            <form method="POST" action="{{ route('replies.store') }}" class="mx-5 mb-3 space-y-2 flex flex-col">
                @csrf

                <div>
                    <input name="post_id" type="text" hidden value="{{ $post->id }}">
                    <input name="parent_reply_id" type="text" hidden value="{{ $reply->id }}">
                    <x-form.text-area name="body" id="body" autocomplete='body' placeholder="Reply"
                        :value="old('body')" rows=3 />
                    <x-form.error :messages="$errors->get('body')" />
                </div>

                <button type="submit" class="btn btn-primary self-end w-full max-w-28">Reply</button>
            </form>
        @endauth
        @if (!empty($parent_replies))
            <li>
        @endif
        <x-list.replies>
            @foreach ($reply->childReplies as $childReply)
                <x-list.item.reply :reply="$childReply" :$user />
            @endforeach
        </x-list.replies>
        @if (!empty($parent_replies))
            </li>
        @endif
        @foreach ($parent_replies as $parent_reply)
            </ul>
            </ul>
        @endforeach
    </div>
</x-layout.app>
