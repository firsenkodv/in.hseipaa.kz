@if(count($content->tarif))
    <div class="content_content-tarif-component">
        <div class="tarif_flex">
            @foreach($content->tarif as $item)
                <div class="tarif__item background_F5F5F7">
                    <h2 class="h2">{{ $item['title'] }}</h2>
                    <div class="tarif_subtitle">{{ $item['subtitle'] }}</div>
                    <div class="tarif_price">{{ price($item['price']) }} {{ config('currency.currency.KZT') }}</div>
                    <div class="tarif_mpr">{{ $item['mpr'] }}</div>
                    <a href="#" class="tarif_checkUser">Доступно после входа</a>
                    <div class="tarif_line"></div>
                    <div class="t_ul">
                        <div class="t_ulLabel">В тарифе:</div>
                        @foreach($item['tarif'] as $tarif)
                            <div class="t_li">{{ $tarif['json_tarif_label'] }}</div>
                        @endforeach
                    </div>

                </div>
            @endforeach
        </div>
    </div>
@endif

