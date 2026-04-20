<div class="cabinet_info__data hh_left user-resume-selection">
    <h4 class="h4 pad_b10">Ваши резюме</h4>
    @if($hasTarif)
      <x-menu.hh-menu-user-resume-component :resumeCount="$resumeCount" />
    @else
  <x-cabinet.not-user-vacancy />

    @endif
</div>
