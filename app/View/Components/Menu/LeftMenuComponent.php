<?php

namespace App\View\Components\Menu;

use Closure;
use Domain\Company\ViewModel\CompanyViewModel;
use Domain\Service\ViewModels\ServiceViewModel;
use Domain\SiteNew\ViewModels\SiteNewViewModel;
use Domain\UseFul\ViewModels\UseFulViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LeftMenuComponent extends Component
{
    public array $left_menu;

    public function __construct($menu)
    {

        if (!$menu) {
            abort(404);
        }

        switch ($menu) {
            case 'news':
                $this->news();
                break;
            case 'usefuls':
                $this->usefuls();
                break;
            case 'services':
                $this->services();
                break;
           case 'companies':
                $this->companies();
                break;
        }

    }

    protected function companies(): void
    {

        $cat = CompanyViewModel::make()->categories();



        $useful = [];
        foreach ($cat as $k => $category) {

            $useful[$k]['category']['section'] = config2('moonshine.company.slug');
            $useful[$k]['category']['url'] =   $useful[$k]['category']['section']."/".$category->slug;
            $useful[$k]['category']['id'] = $category->id;
            $useful[$k]['category']['title'] = ($category->menu)??$category->title;
            $useful[$k]['category']['slug'] = $category->slug;

            $useful[$k]['category']['subcategory'] = [];
        }

        $this->left_menu = $useful;

    }

    protected function news(): void
    {

        $cat = SiteNewViewModel::make()->categories();



        $useful = [];
        foreach ($cat as $k => $category) {

            $useful[$k]['category']['section'] = config2('moonshine.new.slug');
            $useful[$k]['category']['url'] =   $useful[$k]['category']['section']."/".$category->slug;
            $useful[$k]['category']['id'] = $category->id;
            $useful[$k]['category']['title'] = ($category->menu)??$category->title;
            $useful[$k]['category']['slug'] = $category->slug;

            $useful[$k]['category']['subcategory'] = [];
        }

        $this->left_menu = $useful;

    }

    protected function usefuls(): void
    {

        $cat = UseFulViewModel::make()->categories();

        $useful = [];
        foreach ($cat as $k => $category) {

            $useful[$k]['category']['section'] = 'section-' . $category->useful->slug;
            $useful[$k]['category']['url'] =   $useful[$k]['category']['section']."/".$category->slug;
            $useful[$k]['category']['id'] = $category->id;
            $useful[$k]['category']['title'] = ($category->menu)??$category->title;
            $useful[$k]['category']['slug'] = $category->slug;

            if(count($category->subcategory))
            {
                    foreach($category->subcategory as $key => $subcategory) {

                        $useful[$k]['category']['subcategory'][$key]['url'] =   $useful[$k]['category']['section']."/".$category->slug."/".$subcategory->slug;
                        $useful[$k]['category']['subcategory'][$key]['id'] = $subcategory->id;
                        $useful[$k]['category']['subcategory'][$key]['title'] = ($subcategory->menu)??$subcategory->title;
                        $useful[$k]['category']['subcategory'][$key]['slug'] = $subcategory->slug;
                    }

            } else {
                $useful[$k]['category']['subcategory'] = [];
            }
        }

        $this->left_menu = $useful;
    }

    protected function services(): void
    {
        $cat = ServiceViewModel::make()->categories();


        $useful = [];
        foreach ($cat as $k => $category) {

            $useful[$k]['category']['section'] = 'service-' . $category->service->slug;
            $useful[$k]['category']['url'] =   $useful[$k]['category']['section']."/".$category->slug;
            $useful[$k]['category']['id'] = $category->id;
            $useful[$k]['category']['title'] = ($category->menu)??$category->title;
            $useful[$k]['category']['slug'] = $category->slug;

            $useful[$k]['category']['subcategory'] = [];
        }

        $this->left_menu = $useful;
    }


    public function render(): View|Closure|string
    {
        return view('components.menu.left-menu-component');
    }
}
