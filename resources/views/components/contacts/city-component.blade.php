<div class="header_1__phone_cities">

    <div class="phone_rack">
        <a class="app_phone_rack" href="@if($first_city_phone)tel:+{{ format_phone($first_city_phone) }}@endif">
            @if($first_city_phone){{ format_phone($first_city_phone) }}@endif
        </a>
    </div>
    <div class="cities">

        <div class="city_rack "><span class="app_city_rack">@if($first_city_title) {{ $first_city_title }}@endif</span><i class="app_arrow_top_bottom"></i></div>
    </div>
</div>
<div class="cities_list">
    <ul class="cities_list__ul app_cities_list__ul animate__animated animate__fadeInDown">
          @foreach($cities as $city)
              @if($city->json_title)
                <li class="city_li"><span class="city_li-name app_city_select">{{ $city->json_title }}</span>
                    <a class="city_tel" style="text-decoration: none" href="tel:+{{ $city->json_phone  }}">{{ format_phone($city->json_phone) }}</a>
                </li>
              @endif
        @endforeach
    </ul>
</div>
