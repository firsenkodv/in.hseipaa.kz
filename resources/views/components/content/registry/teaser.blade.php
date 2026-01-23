@props([
    'route' => null,
    'item' => null,
    'user' => null,
])
@if(!is_null($item))
<div class="registry__item">
    <div class="registry__flex">
        <div class="registry__left">
            @if(!is_null($route))
                <a href="{{ route($route, $item->id) }}">
                    @endif
                    <div class="registry__avatar"
                         @if($item->avatar)style="background-image: url('{{ asset(intervention('120x120', $item->avatar, 'users/' . $item->id . '/avatar/intervention')) }}')"@endif>
                         @if(!$item->avatar)
                            <div class="mw @if($item->woman) _woman  @endif @if($item->man) _man  @endif"></div>
                        @endif
                    </div>
                    @if(!is_null($route))
                </a>
            @endif
        </div>
        <div class="registry__right">
            <div class="h3">
                @if(is_null($route))
                    {{ $item->username }}
                @else
                    <a href="{{ route($route, $item->id) }}">
                        {{ $item->username }}
                    </a>
                @endif
            </div>

            @if(isset($item->UserCity))
                <div class="registry__list __list0">
                    <span>Город:</span>
                    {{ $item->UserCity->title }}
                </div>
            @endif

            @if($item->UserSpecialist && $item->UserSpecialist->count())
                <div class="registry__list __list1">
                    <span>{{ \App\Enums\User\RegistryStatus::SPECIALIST->text(true) }}:</span>
                    @foreach($item->UserSpecialist as $specialist)
                        {{ $specialist->title }}@if(!$loop->last),
                        @endif
                    @endforeach
                </div>
            @endif

            @if($item->UserExpert && $item->UserExpert->count())
                <div class="registry__list __list2">
                    <span>{{ \App\Enums\User\RegistryStatus::EXPERT->text(true) }}:</span>
                    @foreach($item->UserExpert as $expert)
                        {{ $expert->title }}@if(!$loop->last),
                        @endif
                    @endforeach
                </div>
            @endif

            @if($item->UserProduction && $item->UserProduction->count())
                <div class="registry__list __list2">
                    <span>Вид деятельности:</span>
                    @foreach($item->UserProduction as $production)
                        {{ $production->title }}@if(!$loop->last),
                        @endif
                    @endforeach
                </div>
            @endif

            @if($item->legal_entity)
                <div class="registry__list __list3 ">
                    <span>{{ $item->company }}</span>
                </div>
            @endif

            @if($item->tarif_id)
                @if (!empty($user) && $user->tarif_id)
                <div class="registry__list __list3 ">
                    <a href="tel:{{$item->phone}}">&#9742; {{ format_phone($item->phone) }}</a>
                    @if($item->email && $item->phone)
                        <i>&bull;</i>
                    @endif
                    <span>{{ $item->email }}</span>
                </div>
            @endif
            @endif


        </div>
    </div>
</div>
@endif
