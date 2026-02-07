@props([
'relation' => true
])
<div class="cabinet-user_cabinet-user-personal-data-relation">

    <x-cabinet-rop.cabinet-rop-info />

    <div class="block_exit">
        <x-form action="{{ route('logout_rop') }}">
            <x-form.form-button
                type="submit">
                Выход
            </x-form.form-button>
        </x-form>
    </div>

</div>
