<?php

namespace Domain\SiteNew\ViewModels;


use App\Models\SiteNewModule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class SiteNewModuleViewModel
{
    use Makeable;

   public function items(): Collection|null
    {
     //   return Cache::rememberForever('site_new_modules', function () {

            return SiteNewModule::query()
                ->with('category')
                ->with('item')
                ->get();

       // });

    }



}
