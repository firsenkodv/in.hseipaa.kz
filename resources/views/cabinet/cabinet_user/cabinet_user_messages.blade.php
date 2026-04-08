@extends('layouts.layout')
<x-seo.meta
    title="Ваши сообщения"
    description="Ваши сообщения"
    keywords="Ваши сообщения"
/>
@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('cabinet_user_messages') }}
            </div>

            <x-cabinet.title
                title="Мой профиль"
                :subtitle="(isset($user->UserHuman->title))? $user->UserHuman->title : ''"
            />


            <x-cabinet-user.menu.cabinet-user-top-menu :user="$user"/>

            <div class="block_content__flex reverse">
                <div class="block_content__left">
                 <x-cabinet-user.cabinet-user-personal-data-relation :user="$user" :relation="false"/>
                </div>
                <div class="block_content__right">

                    <div class="modal-form-container middle">
                        <x-form.form
                            method="POST"
                            :action="route('to_manager_message')"
                        >
                            <div class="relative ">
                                <div class="form_title">
                                    <div class="form_title__h1">Написать сообщение</div>
                                    <div class="form_title__h2">Напишите сообщение менеджеру</div>
                                </div>
                                @if(isset($messages) && $messages->isNotEmpty())
                                    <div
                                        class="form_data app_form_data cabinet-messages-container">
                                        @foreach($messages as $msg)
                                            <div class="cabinet-msg-item
                                                @if($msg->sender_type === \App\Models\User::class) message_from_user
                                                @elseif($msg->sender_type === \App\Models\ROP::class) message_from_rop
                                                @elseif($msg->sender_type === \App\Models\Manager::class) message_from_manager
                                                @endif"
                                                data-msg-id="{{ $msg->id }}">
                                                <small>
                                                        <span class="date_minute">{{ date_minute($msg->created_at) }}</span>
                                                    &mdash;
                                                    <span class="username">{{ $msg->sender?->username ?? '—' }}</span>
                                                    @if($msg->sender_type === \App\Models\User::class)
                                                    <button
                                                        type="button"
                                                        class="cabinet-msg-delete"
                                                        data-msg-id="{{ $msg->id }}"
                                                        data-url="{{ route('cabinet_user_message_delete') }}"
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
                                        value="{{ $user->id }}"
                                    />
                                </div>
                                <div class="input-button ">
                                    <x-form.form-submit type="submit" class="w_265_px_important btn-big">Отправить</x-form.form-submit>
                                </div>
                            </div>
                        </x-form.form>
                    </div>





                </div>
            </div>


        </div>
    </section>
@endsection

