@props(['reply', 'user'])

<li>
    <x-card.reply :$reply :$user />
    <x-list.replies>
        @foreach ($reply->childReplies as $reply)
            <x-list.item.reply :$reply :$user />
        @endforeach
    </x-list.replies>
</li>
