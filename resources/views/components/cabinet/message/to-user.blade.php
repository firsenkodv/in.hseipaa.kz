@props([
    'item',
    'class' => ''
])
@php
    $isPublished = $item->published == \App\Enums\User\PublishedUserEnum::PUBLISHED->value;
    $isBlocked   = $item->published == \App\Enums\User\PublishedUserEnum::BLOCKED->value;
@endphp
<div class="to-user {{ $class }}">

<a  title="Написать сообщение" style="background:none;border:none;cursor:pointer;padding:0;color:inherit;" class="open-fancybox to_user_message" data-form="to_user_message" data-transfer='{"user_id": {{ $item->id }}, "action": "message"}'>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
    </svg>
</a>
    <a  title="Одобрить" style="background:none;border:none;cursor:pointer;padding:0;color:inherit;" class="{{ $isPublished ? '' : 'open-fancybox' }} to_user_message_and_published {{ $isPublished ? 'active' : '' }}" @if(!$isPublished) data-form="to_user_message" data-transfer='{"user_id": {{ $item->id }}, "action": "published"}' @endif>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
        </svg>
</a>
    <a  title="На удаление" style="background:none;border:none;cursor:pointer;padding:0;color:inherit;" class="{{ $isBlocked ? '' : 'open-fancybox' }} to_user_message_and_blocked {{ $isBlocked ? 'active' : '' }}" @if(!$isBlocked) data-form="to_user_message" data-transfer='{"user_id": {{ $item->id }}, "action": "blocked"}' @endif>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
        </svg>
    </a>
</div>
