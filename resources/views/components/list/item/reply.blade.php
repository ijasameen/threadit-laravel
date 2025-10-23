<li>
    <x-card.reply :$reply :link="route('replies.show', ['username' => $reply->user->username, 'id' => $reply->id])" />
    <x-list.replies>
        @foreach ($reply->childReplies as $reply)
            <x-list.item.reply :$reply />
        @endforeach
    </x-list.replies>
</li>
