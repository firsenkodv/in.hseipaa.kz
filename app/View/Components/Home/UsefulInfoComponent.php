<?php

namespace App\View\Components\Home;

use App\Models\SiteNewItem;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class UsefulInfoComponent extends Component
{
    public $items;

    public function __construct()
    {
        $this->items = Cache::rememberForever('home_useful_info_items', function () {
            return SiteNewItem::query()
                ->where('published', 1)
                ->with('category')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
        });
    }

    public function render(): View|Closure|string
    {
        return view('components.home.useful-info-component');
    }
}
