<div class="avatar_avatar-user">
    <label class="cu__avatar" @if($user->avatar)style="background-image: url('{{ asset(intervention('160x160', $user->avatar, $intervention)) }}')"@endif>
        @if(!$user->avatar)
            <div class="mw @if($woman) _woman  @endif @if($man) _man  @endif"></div>
        @endif
    </label>
</div>
