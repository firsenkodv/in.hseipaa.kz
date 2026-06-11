@props(['items'])
<div class="cabinet_manager_users training-list">

    <div class="user_user-list cabinet__users">
        <div class="dashboardBox__title">
            <div class="user_user-list-item u_teaser u_teaser_label">
                <div class="username">Название</div>
                <div class="options"></div>
            </div>
        </div>

        @forelse($items as $item)
            <div class="flex c_flex">
                <div class="user_user-list-item u_teaser" data-training-id="{{ $item->id }}">
                    <div class="username">{{ $item->title }}</div>
                    <div class="options">
                        <a href="#"
                           class="open-fancybox training-edit-btn"
                           data-form="admin_training_edit"
                           data-transfer='{"training_id": {{ $item->id }}}'
                           title="Редактировать">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="user_user-list-item u_teaser">
                Дисциплин нет
            </div>
        @endforelse
    </div>

</div>
