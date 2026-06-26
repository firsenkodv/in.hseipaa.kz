<div class="home_useful-info-component teaser_info">
    <div class="flex output-news__topBar">
        <div class="topBar__left">
            <h2 class="h1">Новости</h2>
        </div>
        <div class="topBar__right"></div>
    </div>
    <div class="teaser_info__flex">
        @foreach($items as $item)
            <div class="teaser">
                <div class="teaser_img">
                    @if($item->img)
                        <img src="{{ asset(intervention('356x160', $item->img, 'images/news_info/intervention')) }}"
                             alt="{{ $item->title }}" />
                    @endif
                </div>
                <div class="teaser_desc">

                    {{ title_limit($item->title) }}
                </div>
                <div class="teaser_button">
                    <a href="{{ $item->url }}" class="btn btn-big">Подробнее</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
