<?php

namespace App\View\Components\Home;

use Closure;
use Domain\Service\ViewModels\ServiceViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OutputServiceCategoryComponent extends Component
{

    public array $item;
    public function __construct()
    {
        $service_module = config2_array('moonshine.service_module');
        if(isset($service_module['category_left'])) {
            $category_left = ServiceViewModel::make()->categoryId($service_module['category_left']);
            if(!$service_module['temp_title_left']) {
                $service_module['temp_title_left'] = ($category_left->temp_title)?:$category_left->title;
            }
            if(!$service_module['temp_desc_left']) {
                $service_module['temp_desc_left'] = ($category_left->temp_desc)??'';
            }
            if(!$service_module['temp_price_left']) {
                $service_module['temp_price_left'] = ($category_left->temp_price)??'';
            }
            if(!$service_module['temp_url_left']) {
                $service_module['temp_url_left'] = $category_left->url;
            }
        }
        if(isset($service_module['category_right'])) {
            $category_right = ServiceViewModel::make()->categoryId($service_module['category_right']);
            if(!$service_module['temp_title_right']) {
                $service_module['temp_title_right'] = ($category_right->temp_title)?:$category_right->title;
            }
            if(!$service_module['temp_desc_right']) {
                $service_module['temp_desc_right'] = ($category_right->temp_desc)??'';
            }
            if(!$service_module['temp_price_right']) {
                $service_module['temp_price_right'] = ($category_right->temp_price)??'';
            }
            if(!$service_module['temp_url_right']) {
                $service_module['temp_url_right'] = $category_right->url;
            }


        }

        $this->item = $service_module;


    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home.output-service-category-component');
    }
}
