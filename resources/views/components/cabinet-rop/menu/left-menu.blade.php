<div class="cabinet_radius12_fff cabinet_rop-menu_left-menu">
    <ul class="_left_m nav">
        <li class="{{ active_linkMenu(route('rop_users'))  }}"><a href="{{ route('rop_users') }}">Пользователи
                <span class="_int">{{ $countUsers }}</span>
            </a>
        </li>
        <li class="{{ active_linkMenu(route('rop_no_published_users'))  }}"><a href="{{ route('rop_no_published_users') }}">На модерации
                <span class="_int">{{ $countLockedUsers }}</span>
            </a>
        </li>
        <li class="{{ active_linkMenu(route('rop_deleted_users'))  }}"><a href="{{ route('rop_deleted_users') }}">На удаление
                <span class="_int">{{ $countDeletedUsers }}</span>
            </a>
        </li>
    </ul>
</div>
