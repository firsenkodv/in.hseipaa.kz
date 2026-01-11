
@if(count($tarifs))
    <div class="content_content-tarif-component">
        <div class="tarif_flex">
            @foreach($tarifs as $k => $item)
                <div class="tarif__item background_F5F5F7 {{ $item['id'] }}">
                    <h2 class="h2">{{ $item['title'] }}</h2>
                    <div class="tarif_subtitle">{{ $item['subtitle'] }}</div>
                    <div class="tarif_price">{{ price($item['price']) }} {{ config('currency.currency.KZT') }}</div>
                    <div class="tarif_mpr">{{ $item['mpr'] }}</div>
                    @guest
                        <a href="{{ route('login') }}" class="tarif_checkUser">Доступно после входа</a>
                    @endguest
                    @auth
                       @if($tarif_id ==  $item['id'] )
                            <div class="tarif_btn__center">
                            <div class="btn btn_green">Ваш тариф</div>
                            </div>

                        @else
                           <div class="tarif_btn__center">
                            <a href="#"  class="btn over open-fancybox" data-form="select_tarif"
                               data-transfer='{"tarif_id": {{$item['id']}}}'>Выбрать тариф</a>
                           </div>
                        @endif
                    @endauth
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

