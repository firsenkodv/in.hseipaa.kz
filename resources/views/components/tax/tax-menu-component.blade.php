@if(count($left_menu))

    <div class="tax_tax-menu-component">
        <div class="left_menu">
            <ul class="left_menu__ul">
                @foreach($left_menu as $menu)

                    <li class="{{ active_linkMenu(asset(route('tax_calendar', ['item_slug' => $menu->slug])), 'find') }}">
                        <a href="{{ asset(route('tax_calendar', ['item_slug' => $menu->slug]))}}"><span>{{ ($menu->menu)??$menu->title  }}</span></a>

                    </li>

                @endforeach

            </ul>
        </div>

    </div>
@endif
