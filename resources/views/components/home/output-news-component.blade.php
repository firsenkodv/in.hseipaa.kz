<div class="home_output-news-component">
    <div class="flex output-news__topBar">
        <div class="topBar__left">
            <h2 class="h1">Новости</h2>
        </div>
        <div class="topBar__right">
            <div class="tabs">
                @if(isset($categories))
                    @foreach($categories as $k=>$category)
                        <div class="G_tab{{ $k }} @if($loop->first) active @endif tab">
                            <a href="{{ $category->url }}" class="nursul">{{ $category->title }}</a>
                        </div><!--.G_tab{{ $k }}-->
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="flex output-news__centerBar">
        <div class="centerBar__left">
            <div class="own-carousel__container">
                <!-- Slider main container -->
                <div class="swiper swiper-initialized-custom">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        @foreach($swiper as $item)
                            <div class="swiper-slide">
                                <a href="{{ ($item['link'])?:$item['url'] }}"><img width="778" src="{{ asset(intervention('778x410', $item['img'], 'images/news/intervention')) }}"
                                                alt="{{ $item['title'] }}"></a>
                            </div>
                        @endforeach

                    </div>

                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev prev-custom"></div>
                    <div class="swiper-button-next next-custom"></div>

                </div>

            </div>
        </div>
        <div class="centerBar__right">

            <div class="output_news__module scroll-block">

                @if(count($items))
                @foreach($items as $item)

                        <a class="on__link" href="{{ $item['url'] }}">
                            <div class="pad_b10">
                                <span class="on__date">{{ rusdate3($item['created_at']) }}</span>
                                <span class="on__category">{{ $item['category'] }}</span>
                            </div><!--.wi33_top-->
                            <div class="on__title">{!!  $item['title'] !!}
                            </div>
                        </a>

                @endforeach
                @endif


            </div>

        </div>
    </div>
</div>
