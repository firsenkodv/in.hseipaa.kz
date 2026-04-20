<div class="cabinet_info__data user-vacancy-selection">
    <h4 class="h4 pad_b10">Ваши вакансии</h4>
    @if($hasTarif)
      <x-menu.hh-menu-user-vacancy-component />
    @else
  <x-cabinet.not-user-vacancy />

    @endif
</div>
