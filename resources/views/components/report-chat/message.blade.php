@props(['msg', 'senderRole' => 'staff'])

<div class="report-chat__msg report-chat__msg--{{ $senderRole }}" data-msg-id="{{ $msg->id }}">
    <div class="report-chat__msg-meta">
        <span class="report-chat__msg-time">{{ date_minute($msg->created_at) }}</span>
        <span class="report-chat__msg-author">{{ $msg->sender?->username ?? '—' }}</span>
    </div>
    <div class="report-chat__msg-body">{!! nl2br(e($msg->body)) !!}</div>
</div>
