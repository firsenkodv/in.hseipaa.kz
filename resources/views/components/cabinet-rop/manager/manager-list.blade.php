<div class="cabinet__users_scroll">
<div class="manager_manager-list cabinet__users">
    @foreach($items as $item)
        <a href="{{route('rop_update_manager', $item->id)}}" class="manager_manager-list-item u_teaser">
            <div class="username">
                <span class="@if($item->main == \App\Enums\Moonshine\StatusManagerEnum::MAIN->value)main @endif">{{$item->username}}</span>
            </div>
            <div class="email">
                {{$item->email}}
            </div>
            <div class="phone">
                {{format_phone($item->phone)}}
            </div>
        </a>
    @endforeach
</div>
</div>
