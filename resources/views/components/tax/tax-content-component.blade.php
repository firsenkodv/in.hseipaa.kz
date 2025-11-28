<div class="tax_tax-content-component tax_wrapper">

    <div class="quarters">
        <div class="quarter app_quarter @if($quarter == 'quarter1' ) active  @endif" data-quarter="quarter1">1 квартал</div>
        <div class="quarter app_quarter @if($quarter == 'quarter2' ) active  @endif" data-quarter="quarter2">2 квартал</div>
        <div class="quarter app_quarter @if($quarter == 'quarter3' ) active  @endif" data-quarter="quarter3">3 квартал</div>
        <div class="quarter app_quarter @if($quarter == 'quarter4' ) active  @endif" data-quarter="quarter4">4 квартал</div>
    </div>

    <div class="mounts">

        <div class="app_mounts q_flex quarter1 @if($quarter == 'quarter1' ) active  @endif">
        <div class="mount app_mount m_quarter1  @if($mounth=="jan") active @endif" data-month="jan">Январь</div>
        <div class="mount app_mount @if($mounth=="feb") active @endif" data-month="feb">Февраль</div>
        <div class="mount app_mount @if($mounth=="mai") active @endif" data-month="mar">Март</div>
        </div>

        <div class="app_mounts q_flex quarter2 @if($quarter == 'quarter2' ) active  @endif">
        <div class="mount app_mount m_quarter2 @if($mounth=="apr") active @endif" data-month="apr">Апрель</div>
        <div class="mount app_mount @if($mounth=="mai") active @endif" data-month="mai">Май</div>
        <div class="mount app_mount @if($mounth=="jun") active @endif" data-month="jun">Июнь</div>
        </div>

        <div class="app_mounts q_flex quarter3 @if($quarter == 'quarter3' ) active  @endif">
        <div class="mount app_mount m_quarter3 @if($mounth=="jul") active @endif" data-month="jul">Июль</div>
        <div class="mount app_mount @if($mounth=="aug") active @endif" data-month="aug">Август</div>
        <div class="mount app_mount @if($mounth=="sept") active @endif" data-month="sept">Сентябрь</div>
        </div>

        <div class="app_mounts q_flex quarter4 @if($quarter == 'quarter4' ) active  @endif">
        <div class="mount app_mount m_quarter4 @if($mounth=="oct") active @endif"  data-month="oct">Октябрь</div>
        <div class="mount app_mount @if($mounth=="nov") active @endif"  data-month="nov">Ноябрь</div>
        <div class="mount app_mount @if($mounth=="dec") active @endif"  data-month="dec">Декабрь</div>
        </div>

    </div>

 {{-- @dump($item->jan)--}}

    <div class="tax-contents">
        <div class="q_none  d_quarter1 jan @if($mounth=="jan") active @endif">
            @if($item['jan'])
                @foreach($item['jan'] as $m)
                    <div class="flex tax-content">
                    <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                    <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="q_none feb @if($mounth=="feb") active @endif">
            @if($item['feb'])
                @foreach($item['feb'] as $m)
                    <div class="flex tax-content">
                    <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                    <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="q_none mar @if($mounth=="mar") active @endif" >
            @if($item['mar'])
                @foreach($item['mar'] as $m)
                    <div class="flex tax-content">
                    <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                    <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="q_none d_quarter2 apr @if($mounth=="apr") active @endif">
            @if($item['apr'])
                @foreach($item['apr'] as $m)
                    <div class="flex tax-content">
                    <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                    <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="q_none mai @if($mounth=="mai") active @endif" >
            @if($item['mai'])
                @foreach($item['mai'] as $m)
                    <div class="flex tax-content">
                    <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                    <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="q_none jun @if($mounth=="jun") active @endif" >
            @if($item['jun'])
                @foreach($item['jun'] as $m)
                    <div class="flex tax-content">
                    <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                    <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="q_none d_quarter3 jul @if($mounth=="jul") active @endif" >
            @if($item['jul'])
                @foreach($item['jul'] as $m)
                    <div class="flex tax-content">
                    <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                    <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="q_none aug @if($mounth=="aug") active @endif" >
            @if($item['aug'])
                @foreach($item['aug'] as $m)
                    <div class="flex tax-content">
                    <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                    <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="q_none sept @if($mounth=="sept") active @endif">
            @if($item['sept'])
                @foreach($item['sept'] as $m)
                    <div class="flex tax-content">
                    <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                    <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="q_none d_quarter4 oct @if($mounth=="oct") active @endif">
            @if($item['oct'])
                @foreach($item['oct'] as $m)
                    <div class="flex tax-content">
                    <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                    <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="q_none nov @if($mounth=="nov") active @endif" >
            @if($item['nov'])
                @foreach($item['nov'] as $m)
                    <div class="flex tax-content">
                    <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                    <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="q_none dec @if($mounth=="dec") active @endif" >
            @if($item['dec'])
                @foreach($item['dec'] as $m)
                    <div class="flex tax-content">
                    <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                    <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                    </div>
                @endforeach
            @endif
        </div>
       </div>

    <div class="desc pad_t16">{!! $item['desc'] !!}</div>

</div>
