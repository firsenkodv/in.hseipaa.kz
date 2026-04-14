@props([
'relation' => true
])
<div class="cabinet-user_cabinet-user-personal-data-relation">

   <x-cabinet-manager.cabinet-manager-info />

   <x-cabinet-manager.menu.left-menu />

    <div class="block_exit">
        <x-form action="{{ route('logout_manager') }}">
            <x-form.form-button
                type="submit">
                Выход
            </x-form.form-button>
        </x-form>
    </div>

</div>
