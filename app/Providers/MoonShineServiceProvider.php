<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Pages\SettingPage;
use App\MoonShine\Pages\ContactPage;
use App\MoonShine\Resources\UsefulResource;
use App\MoonShine\Resources\UsefulCategoryResource;
use App\MoonShine\Resources\UsefulSubcategoryResource;
use App\MoonShine\Resources\UsefulItemResource;
use App\MoonShine\Resources\SiteNewResource;
use App\MoonShine\Resources\SiteNewItemResource;
use App\MoonShine\Resources\ServiceResource;
use App\MoonShine\Resources\ServiceCategoryResource;
use App\MoonShine\Resources\ServiceItemResource;
use App\MoonShine\Pages\NewPage;
use App\MoonShine\Resources\CompanyCategoryResource;
use App\MoonShine\Pages\CompanyPage;
use App\MoonShine\Resources\CompanyItemResource;
use App\MoonShine\Resources\TaxResource;
use App\MoonShine\Resources\AxeldPassportResource;
use App\MoonShine\Pages\UsefulModulePage;
use App\MoonShine\Resources\SiteNewModuleResource;
use App\MoonShine\Pages\ServiceModulePage;
use App\MoonShine\Pages\HomePage;
use App\MoonShine\Resources\MzpResource;
use App\MoonShine\Resources\TarifResource;
use App\MoonShine\Resources\SavedFormDataResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     * @param  MoonShineConfigurator  $config
     *
     */
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                UsefulResource::class,
                UsefulCategoryResource::class,
                UsefulSubcategoryResource::class,
                UsefulItemResource::class,
                SiteNewResource::class,
                SiteNewItemResource::class,
                ServiceResource::class,
                ServiceCategoryResource::class,
                ServiceItemResource::class,
                CompanyCategoryResource::class,
                CompanyItemResource::class,
                TaxResource::class,
                AxeldPassportResource::class,
                SiteNewModuleResource::class,
                MzpResource::class,
                TarifResource::class,
                SavedFormDataResource::class,
            ])
            ->pages([
                ...$config->getPages(),
                SettingPage::class,
                ContactPage::class,
                NewPage::class,
                CompanyPage::class,
                UsefulModulePage::class,
                ServiceModulePage::class,
                HomePage::class,
            ])
        ;
    }
}
