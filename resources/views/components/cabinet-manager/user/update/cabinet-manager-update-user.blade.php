@props([
    'item'
])
<div class="cabinet-user-update_update_cabinet-user-update">

    <div class="cabinet_user_personal__flex">
        <div class="cabinet_user_personal__left">
            <x-avatar.avatar-user
                :user="$item"
                :route="route('upload_manager-user_photo')"
                folder="users"
                :userid="$item->id"
            />
        </div>
        <div class="cabinet_user_personal__right">
            <div class="flex in-edit">
                <div class="cu_username left">
                    <h1 class="h1">{{ $item->username }}</h1>
                    <p class="_subtitle">
                        {{ isset($item->UserCity->title) ? $item->UserCity->title : 'Город не указан' }}
                    </p>
                    <p class="{{ \App\Enums\User\PublishedUserEnum::fromValue($item->published)->class() }}">
                        {{ $item->published_user }}
                    </p>
                </div>
                <div class="right">
                    <x-cabinet.message.to-user :item="$item" role="manager"/>
                </div>
            </div>
        </div>
    </div>

    <div class="cabinet_user_update_handel">
        <x-cabinet.update-user :user="$item" :route="route('manager_update_post_user')"/>
    </div>

    @php
        $tarifs = \Domain\Tarif\ViewModels\Tarif::make()->tarifs();
    @endphp

    <div class="manager_tarif_block">
        <h2 class="h2 pad_b20 pad_t10">Тариф пользователя {!!  !$item->tarif_id ? ' — <span style="color:red">Тариф не выбран</span>' : '' !!}</h2>
        <div class="tarif_flex">
            @foreach($tarifs as $tarif)
                <div class="tarif__item background_F5F5F7">
                    <h2 class="h2">{{ $tarif->title }}</h2>
                    <div class="tarif_subtitle">{{ $tarif->subtitle }}</div>
                    <div class="tarif_price">{{ price($tarif->price) }} {{ config('currency.currency.KZT') }}</div>
                    <div class="tarif_mpr">{{ $tarif->mpr }}</div>

                    <div class="tarif_btn__center">
                        @if($item->tarif_id == $tarif->id)
                            <div class="btn btn_green">Текущий тариф</div>
                        @else
                            <form method="POST" action="{{ route('manager_set_user_tarif') }}" class="js-manager-set-tarif-form">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $item->id }}">
                                <input type="hidden" name="tarif_id" value="{{ $tarif->id }}">
                                <button type="submit" class="btn over" data-tarif-title="{{ $tarif->title }}">
                                    Выбрать тариф
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="tarif_line"></div>
                    <div class="t_ul">
                        <div class="t_ulLabel">В тарифе:</div>
                        @foreach($tarif->tarif as $t)
                            <div class="t_li">{{ $t['json_tarif_label'] }}</div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
