<div class="avatar_avatar-user">
@if(isset($readonly) && $readonly)
    <div class="cu__avatar" @if($user->avatar)style="background-image: url('{{ asset(intervention('160x160', $user->avatar, $intervention)) }}')"@endif>
        @if(!$user->avatar)
            <div class="mw @if($woman) _woman  @endif @if($man) _man  @endif"></div>
        @endif
    </div>
@else
    <label class="cu__avatar app_cu__avatar" data-url="{{ $route }}" data-managerid="{{ $managerid }}" data-userid="{{ $userid }}" for="photoInput" @if($user->avatar)style="background-image: url('{{ asset(intervention('160x160', $user->avatar, $intervention)) }}')"@endif>
        @if(!$user->avatar)
            <div class="mw @if($woman) _woman  @endif @if($man) _man  @endif"></div>
        @endif
        <input type="file" id="photoInput" accept="image/*" />
    </label>
@endif
</div>
