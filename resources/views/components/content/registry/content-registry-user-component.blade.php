@props([
    'item' => null
])
@if(!is_null($item))
    <div class="content-registry-user-component">
        <div class="ru_list">
            @if($item->individual)
                <div class="ru_list__option">
                    <div class="ru_l">{{ config('site.constants.about_me') }}:</div>
                    <div class="ru_r">{!! empty($item->about_me) ? '&mdash;' : $item->about_me !!}
                    </div>
                </div>
                <div class="ru_list__option">
                    <div class="ru_l">{{ config('site.constants.experience') }}:</div>
                    <div class="ru_r">{!! empty($item->experience) ? '&mdash;' : $item->experience !!}</div>
                </div>
            @endif

            <div class="ru_list__option">
                <div class="ru_l">{{ config('site.constants.languages')}}:</div>
                <div class="ru_r">
                    @forelse($item->UserLanguage as $language)
                        {{ $language->title }}@if(!$loop->last),
                        @endif
                        @empty
                            &mdash;
                        @endforelse
                </div>
            </div>
            @if($item->tarif_id)
                @if (!empty($user) && $user->tarif_id)
                    <div class="my_network">
                        <h2 class="h3 pad_b10 pad_t20">{{ config('site.constants.network_message') }}</h2>
                        <div class="ru_list__option">
                            <div class="ru_l">{{ config('site.constants.telegram') }}:</div>
                            <div class="ru_r"><a target="_blank" rel="nofollow"
                                                 href="{{ $item->telegram }}">{{ $item->original_telegram }}</a></div>
                        </div>
                        <div class="ru_list__option">
                            <div class="ru_l">{{ config('site.constants.whatsapp') }}:</div>
                            <div class="ru_r"><a target="_blank" rel="nofollow"
                                                 href="{{ $item->whatsapp }}">{{ $item->original_whatsapp }}</a></div>
                        </div>
                        <div class="ru_list__option">
                            <div class="ru_l">{{ config('site.constants.instagram') }}:</div>
                            <div class="ru_r"><a target="_blank" rel="nofollow"
                                                 href="{{ $item->instagram }}">{{ $item->original_instagram }}</a></div>
                        </div>
                        <div class="ru_list__option">
                            <div class="ru_l">{{ config('site.constants.site') }}:</div>
                            <div class="ru_r">{{ $item->website }}</div>

                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endif
