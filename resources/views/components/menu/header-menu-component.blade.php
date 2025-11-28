<div class="menu_header-menu-component">
    <nav>
        <ul class="top_menu app_top_menu">

            @if($menu_rendered)
                @foreach($menu_rendered as $item)

                    <li class="{{ $item['class_li'] }}  @if($item['parent']) parent @endif {{ active_linkMenu(asset($item['link']), 'find')  }}">
                        <a class="{{ $item['class'] }}" {{ $item['data'] }}  href="{{ asset($item['link']) }}">{{ $item['text'] }} @if($item['parent'])<em class="arrow"></em>@endif</a>

                        @if($item['parent'])
                            @if(isset($item['child']))
                            <ul class="submenu">
                        @foreach($item['child'] as $item_child)
                                    <li class="{{ $item_child['class_li'] }}   {{ active_linkMenu(asset($item_child['link']), 'find')  }}">
                                        <a class="{{ $item_child['class'] }}" {{ $item_child['data'] }} href="{{ asset($item_child['link']) }}">{{ $item_child['text'] }}</a>
                                    </li>
                        @endforeach
                            </ul>
                        @endif
                        @endif
                    </li>



                @endforeach
            @endif

        </ul>
    </nav>
</div>
