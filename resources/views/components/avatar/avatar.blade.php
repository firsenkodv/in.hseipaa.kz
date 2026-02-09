@props([
    'class' => 'registry__avatar',
    'avatar' => '',
    'thumbnail' => '120x120',
    'path' => '',
    'man' => true,
    'woman' => false,
])
<div class="{{ $class }}"
     @if($avatar)
         style="background-image: url('{{ asset(intervention($thumbnail, $avatar, $path)) }}')"
    @endif>
    @if(!$avatar)
        <div class="mw @if($woman) _woman  @endif @if($man) _man  @endif"></div>
    @endif
</div>
