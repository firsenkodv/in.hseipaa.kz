<div class="home_output-category-component output relative">
    <h2 class="h1 pad_b26">Полезное</h2>
    <div class="home_out_c_cal flex">
        <div class="output_flex home_out_c_cal__left">
            <div class="output__left">
                <div class="o__flex output_title">
                    <div class="output_icon__cert "></div>
                    <div class="output_t"><span>{{ $items['left']['title'] }}</span></div>
                </div>
                <div class="output_text scroll-block">
                    @if(count($items['left']['teasers'] ))
                        @foreach($items['left']['teasers'] as $teaser)
                            
                            <div class="output_text__item">
                                <a href="{{ $teaser['url'] }}">{!! $teaser['title'] !!}</a>
                            </div>

                        @endforeach()
                    @endif
                </div>

            </div>


            <div class="output__right">
                <div class="o__flex output_title">
                    <div class="output_icon__edu "></div>
                    <div class="output_t"><span>{{ $items['right']['title']  }}</span></div>
                </div>
                <div class="output_text scroll-block">
                    @if(count($items['right']['teasers'] ))
                        @foreach($items['right']['teasers'] as $teaser)

                            <div class="output_text__item">
                                <a href="{{ $teaser['url'] }}">{!! $teaser['title'] !!}</a>
                            </div>

                        @endforeach()
                    @endif
                </div>

            </div>
        </div>
        <div class="home_out_c_cal__right">
            <div class="output_calendar" id="app_calendar__module">
                <h3 class="h3">Календарь налоговой отчетности</h3>
                <div class="output_calendar__module scroll-block">

                    <div class="tax-contents">
                        <div class="d_quarter1 jan @if($mounth=="jan") super @endif">
                            @if($tax['jan'])
                                @foreach($tax['jan'] as $m)
                                    <div class="flex tax-content">
                                        <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                                        <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class=" feb @if($mounth=="feb") super @endif">
                            @if($tax['feb'])
                                @foreach($tax['feb'] as $m)
                                    <div class="flex tax-content">
                                        <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                                        <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class=" mar @if($mounth=="mar") super @endif">
                            @if($tax['mar'])
                                @foreach($tax['mar'] as $m)
                                    <div class="flex tax-content">
                                        <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                                        <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class=" d_quarter2 apr @if($mounth=="apr") super @endif">
                            @if($tax['apr'])
                                @foreach($tax['apr'] as $m)
                                    <div class="flex tax-content">
                                        <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                                        <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class=" mai @if($mounth=="mai") super @endif">
                            @if($tax['mai'])
                                @foreach($tax['mai'] as $m)
                                    <div class="flex tax-content">
                                        <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                                        <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class=" jun @if($mounth=="jun") super @endif">
                            @if($tax['jun'])
                                @foreach($tax['jun'] as $m)
                                    <div class="flex tax-content">
                                        <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                                        <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class=" d_quarter3 jul @if($mounth=="jul") super @endif">
                            @if($tax['jul'])
                                @foreach($tax['jul'] as $m)
                                    <div class="flex tax-content">
                                        <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                                        <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class=" aug @if($mounth=="aug") super @endif">
                            @if($tax['aug'])
                                @foreach($tax['aug'] as $m)
                                    <div class="flex tax-content">
                                        <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                                        <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class=" sept @if($mounth=="sept") super @endif">
                            @if($tax['sept'])
                                @foreach($tax['sept'] as $m)
                                    <div class="flex tax-content">
                                        <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                                        <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class=" d_quarter4 oct @if($mounth=="oct") super @endif">
                            @if($tax['oct'])
                                @foreach($tax['oct'] as $m)
                                    <div class="flex tax-content">
                                        <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                                        <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class=" nov @if($mounth=="nov") super @endif">
                            @if($tax['nov'])
                                @foreach($tax['nov'] as $m)
                                    <div class="flex tax-content">
                                        <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                                        <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class=" dec @if($mounth=="dec") super @endif">
                            @if($tax['dec'])
                                @foreach($tax['dec'] as $m)
                                    <div class="flex tax-content">
                                        <div class="ya_it_left">{{rusdate5($m['json_date'])}}</div>
                                        <div class="ya_it_right desc">{!!  $m['json_text'] !!}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>

                <div class="redirect_tax">
                    <a href="{{ route('tax_calendar', ['item_slug' => $tax->slug]) }}" class="btn over">Посмотреть
                        полный календарь</a>
                </div>
            </div>
        </div>

    </div>
</div>
