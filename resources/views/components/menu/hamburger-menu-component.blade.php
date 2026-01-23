@if(count($menu_rendered))
    <div class="menu_hamburger-menu-component menu-site">
        <div class="f_menu__flex">
            @foreach($menu_rendered as $k => $menu)
                <div class="f_menu_{{$k}}">
                    @foreach($menu as $item)
                        <li class="{{ active_linkMenu(asset($item['link']), 'find')  }}"><a href="{{ trim($item['link']) }}">{{ trim($item['text']) }}</a></li>

                    @endforeach

                </div>
            @endforeach
        </div>
    </div>
@endif
