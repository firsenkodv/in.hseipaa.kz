@if($content->temp_img)
    <div class="content_content-other-component desc">
        <div class="flex other_flex">
            <div class="other_left">
                <img width="389" height="335" src="{{ asset(intervention('389x335', $content->temp_img, 'service/intervention')) }}"
                     alt="{{ $content->temp_title }}">
            </div>
            <div class="other_right">
                <div class="temp_title">
                    <h2>{{ ($content->temp_title)??$content->title }}</h2>
                </div>
                <div class="temp_desc">
                    {!!  $content->temp_desc !!}
                </div>
                <div class="temp_price">
                    {!!  $content->temp_price !!}
                </div>
            </div>
        </div>

    </div>
@endif
