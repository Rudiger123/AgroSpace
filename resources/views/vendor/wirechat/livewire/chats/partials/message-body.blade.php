<div class="flex gap-x-2 items-center">

    {{-- Only show if AUTH is onwer of message --}}
    @if ($belongsToAuth)
        <span class="font-semibold text-xs text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full">
            @lang('wirechat::chats.labels.you')
        </span>
    @elseif(!$belongsToAuth && $group !== null)
        <span class="font-semibold text-xs text-gray-700 bg-gray-100 px-2 py-0.5 rounded-full">
            {{ $lastMessage->sendable?->display_name }}
        </span>
    @endif

    <p @class([
        'truncate text-sm gap-2 items-center',
        'font-semibold text-gray-900' =>
            !$isReadByAuth && !$lastMessage?->ownedBy($this->auth),
        'font-normal text-gray-600' =>
            $isReadByAuth && !$lastMessage?->ownedBy($this->auth),
        'font-normal text-gray-500' =>
            $isReadByAuth && $lastMessage?->ownedBy($this->auth),
    ])>
        {{ $lastMessage->body != '' ? Str::limit($lastMessage->body, 30) : ($lastMessage->isAttachment() ? '📎 '.__('wirechat::chats.labels.attachment') : '') }}
    </p>

    <span class="font-medium px-2 py-1 text-xs shrink-0 text-gray-600 bg-gray-100 rounded-full">
        @if ($lastMessage->created_at->diffInMinutes(now()) < 1)
            @lang('wirechat::chats.labels.now')
        @else
            {{ $lastMessage->created_at->shortAbsoluteDiffForHumans() }}
        @endif
    </span>

</div>