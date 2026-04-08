<div class="modal-form-container mini">
    <x-form.form
        method="POST"
        :action="route('to_user_message')"
    >
    <div class="modal_padding relative ">
        <div class="form_title">
            <div class="form_title__h1">Написать сообщение</div>
            <div class="form_title__h2">Напишите сообщение пользователю</div>
        </div>
        @if(isset($messages) && $messages->isNotEmpty())
        <div
            class="form_data app_form_data cabinet-messages-container"
            style="max-height:260px;overflow-y:auto;margin-bottom:12px;user-select:text;-webkit-user-select:text;"
            onmousedown="event.stopPropagation()"
        >
            @foreach($messages as $msg)
            <div class="cabinet-msg-item
                @if($msg->sender_type === \App\Models\User::class) message_from_user
                @elseif($msg->sender_type === \App\Models\ROP::class) message_from_rop
                @elseif($msg->sender_type === \App\Models\Manager::class) message_from_manager
                @endif"
                data-msg-id="{{ $msg->id }}">
                <small>
                    <span class="date_minute">
                        {{ date_minute($msg->created_at) }}</span>
                    &mdash;
                    <span class="username">
                    {{ $msg->sender?->username ?? '—' }}
                    </span>
                    @if(
                        ($role === 'manager' && $msg->sender_type === \App\Models\Manager::class) ||
                        ($role === 'rop'     && $msg->sender_type === \App\Models\ROP::class)
                    )
                        <button
                            type="button"
                            class="cabinet-msg-delete"
                            data-msg-id="{{ $msg->id }}"
                            data-url="{{ route('cabinet_message_delete') }}"
                            style="background:none;border:none;cursor:pointer;color:#c0392b;padding:0 0 0 6px;"
                            title="Удалить"
                        >&#x2715;</button>
                    @endif
                </small>
                <div class="message_body">{!! $msg->body !!}</div>
            </div>
            @endforeach
        </div>
        @endif
        <div class="form_data app_form_data">
            <x-form.form-textarea
                name="body"
                class="about_me"
                editor="true"
                label="Сообщение"
                value=""
            />
            <x-form.form-input
                name="user_id"
                type="hidden"
                value="{{ $user_id }}"
            />
            <x-form.form-input
                name="action"
                type="hidden"
                value="{{ $action }}"
            />
            <x-form.form-input
                name="role"
                type="hidden"
                value="{{ $role }}"
            />
        </div>
        <div class="input-button ">
            <x-form.form-submit type="submit" class="w_265_px_important btn-big {{ ($action === 'published') ? 'btn_green' : '' }}">
                @if($action === 'published') Опубликовать
                @elseif($action === 'blocked') Заблокировать
                @else Отправить
                @endif
            </x-form.form-submit>
        </div>
    </div>
    </x-form.form>
</div>


