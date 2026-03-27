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
        <div class="form_data app_form_data">
            <x-form.form-textarea
                name="message"
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



