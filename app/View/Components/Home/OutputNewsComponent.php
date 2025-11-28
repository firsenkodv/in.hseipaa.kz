<?php

namespace App\View\Components\Home;

use Closure;
use Domain\SiteNew\ViewModels\SiteNewModuleViewModel;
use Domain\SiteNew\ViewModels\SiteNewViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OutputNewsComponent extends Component
{
    public $categories;
    public array $items;
    public array $swiper;

    public function __construct()
    {
        $this->categories = SiteNewViewModel::make()->getCategories();

        $items = SiteNewViewModel::make()->items();

        if ($items) {
            $resultArray = [];

            foreach ($items as $k => $item) {

                $resultArray[$k]['title'] = ($item->short_desc) ?: $item->title;
                $resultArray[$k]['created_at'] = $item->created_at;
                $resultArray[$k]['subcategory'] = $item->parent_subcategory;
                $resultArray[$k]['category'] = (isset($item->category))?$item->category->title: '';
                $resultArray[$k]['url'] = $item->url;

            }
        }
        $this->items = $resultArray;

        $swiper = SiteNewModuleViewModel::make()->items();
        if ($swiper) {
            $resultArray = [];

            foreach ($swiper as $k => $item) {

                $resultArray[$k]['title'] = $item->title;
                $resultArray[$k]['img'] = $item->img;
                $resultArray[$k]['link'] = $item->link;
                $resultArray[$k]['url'] = '#';
                if(isset($item->category))
                {
                    $resultArray[$k]['url'] = $item->category->url;
                }
                if(isset($item->item))
                {
                    $resultArray[$k]['url'] = $item->item->url;
                }

            }
        }
        $this->swiper = $resultArray;


    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home.output-news-component');
    }
}
