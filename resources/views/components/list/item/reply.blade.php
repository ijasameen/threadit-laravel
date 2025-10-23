<li>
    <x-card.reply :$reply />
    <x-list.replies>
        @foreach ($reply->childReplies as $reply)
            <x-list.item.reply :$reply />
        @endforeach
    </x-list.replies>
</li>
