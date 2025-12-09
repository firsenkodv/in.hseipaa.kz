<div class="mzp_mzp-content-component">

    <div class="mzp_th tr__bold mzp_th__top">
        <div class="mzp_th__td">{{ config2('moonshine.setting.mzp_page_td_1') }}</div>
        <div class="mzp_th__td">{{ config2('moonshine.setting.mzp_page_td_2') }}</div>
        <div class="mzp_th__td">{{ config2('moonshine.setting.mzp_page_td_3') }}</div>
        <div class="mzp_th__td">{{ config2('moonshine.setting.mzp_page_td_4') }}</div>
    </div>
    @if($items)
        @foreach($items as $item)
            <div class="mzp_th"><div class="mzp_year">
                    {{ $item->y }} год
                </div>
                </div>
            <a href="{{ route('mzp_item', ['item_slug' => $item->slug]) }}" class="mzp_th">
                <div class="mzp_th__td">
                        @foreach($item->td_1 as $td)
                        <div class="td__title">{{ config2('moonshine.setting.mzp_page_td_1') }}</div>
                        <div class="td__text">{{ $td['td_1_text'] }}</div>
                        <div class="td__date">с {{ rusdate3($td['td_1_date']) }}</div>
                        @endforeach
                </div>
                <div class="mzp_th__td">
                    @foreach($item->td_2 as $td)
                        <div class="td__title">{{ config2('moonshine.setting.mzp_page_td_2') }}</div>
                        <div class="td__text">{{ $td['td_2_text'] }}</div>
                        <div class="td__date">с {{ rusdate3($td['td_2_date']) }}</div>
                    @endforeach
                </div>
                <div class="mzp_th__td">
                    @foreach($item->td_3 as $td)
                        <div class="td__title">{{ config2('moonshine.setting.mzp_page_td_3') }}</div>
                        <div class="td__text">{{ $td['td_3_text'] }}</div>
                        <div class="td__date">с {{ rusdate3($td['td_3_date']) }}</div>
                    @endforeach
                    </div>
                <div class="mzp_th__td">
                    @foreach($item->td_4 as $td)
                        <div class="td__title">{{ config2('moonshine.setting.mzp_page_td_4') }}</div>
                        <div class="td__text td__bold">{{ $td['td_4_text'] }}</div>

                    @endforeach
                </div>
            </a>
        @endforeach

        {{ $item = null }}
    @endif

    @if($item)
        <div class="mzp_th"><div class="mzp_year">
                {{ $item->y }} год
            </div>
        </div>
        <div  class="mzp_th">
            <div class="mzp_th__td">
                @foreach($item->td_1 as $td)
                    <div class="td__title">{{ config2('moonshine.setting.mzp_page_td_1') }}</div>
                    <div class="td__text">{{ $td['td_1_text'] }}</div>
                    <div class="td__date">с {{ rusdate3($td['td_1_date']) }}</div>
                @endforeach
            </div>
            <div class="mzp_th__td">
                @foreach($item->td_2 as $td)
                    <div class="td__title">{{ config2('moonshine.setting.mzp_page_td_2') }}</div>
                    <div class="td__text">{{ $td['td_2_text'] }}</div>
                    <div class="td__date">с {{ rusdate3($td['td_2_date']) }}</div>
                @endforeach
            </div>
            <div class="mzp_th__td">
                @foreach($item->td_3 as $td)
                    <div class="td__title">{{ config2('moonshine.setting.mzp_page_td_3') }}</div>
                    <div class="td__text">{{ $td['td_3_text'] }}</div>
                    <div class="td__date">с {{ rusdate3($td['td_3_date']) }}</div>
                @endforeach
            </div>
            <div class="mzp_th__td">
                @foreach($item->td_4 as $td)
                    <div class="td__title">{{ config2('moonshine.setting.mzp_page_td_4') }}</div>
                    <div class="td__text td__bold">{{ $td['td_4_text'] }}</div>

                @endforeach
            </div>
        </div>
    @endif



</div>
