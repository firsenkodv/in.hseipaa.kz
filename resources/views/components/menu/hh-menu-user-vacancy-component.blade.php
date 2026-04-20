<div class="pad_t10 cabinet_rop-menu_left-menu">
    <ul class="_left_m nav">
        <li class="{{ active_linkMenu(route('rop_users'))  }}"><a href="{{ route('rop_users') }}">Пользователи
                <span class="_int">9</span>
            </a>
        </li>
        <li class="{{ active_linkMenu(route('rop_no_published_users'))  }}"><a href="{{ route('rop_no_published_users') }}">На модерации
                <span class="_int">4</span>
            </a>
        </li>
        <li class="{{ active_linkMenu(route('rop_deleted_users'))  }}"><a href="{{ route('rop_deleted_users') }}">На удаление
                <span class="_int">3</span>
            </a>
        </li>
    </ul>
</div>
