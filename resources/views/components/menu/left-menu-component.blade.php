@if(count($left_menu))

    <div class="menu_left-menu-component">
        <div class="left_menu">
            <ul class="left_menu__ul">
                @foreach($left_menu as $menu)

                    <li class="@if(count($menu['category']['subcategory'])) parent @endif {{ active_linkMenu(asset($menu['category']['url']), 'find') }}">
                        <a href="{{ asset($menu['category']['url']) }}"><span>{{ $menu['category']['title']  }}</span></a>
                        @if(count($menu['category']['subcategory']))
                            <span class="left_arrow app_left_arrow"></span>
                            <ul class="submenu {{ active_linkMenu(asset($menu['category']['url']), 'find') }}">
                                @foreach($menu['category']['subcategory'] as $submenu)
                                    <li class="{{ active_linkMenu(asset($submenu['url']), 'find') }}"><a href="{{ asset( $submenu['url']) }}"><span>{{ $submenu['title'] }}</span></a></li>
                                @endforeach
                            </ul>
                        @endif


                    </li>

                @endforeach

            </ul>
        </div>

    </div>
@endif
