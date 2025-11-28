<?php

namespace App\View\Components\Home;

use Closure;
use Domain\Tax\ViewModels\TaxViewModel;
use Domain\UseFul\ViewModels\UseFulViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OutputCategoryComponent extends Component
{

    public $tax;

    public $mounth;

    public array $items;


    public function __construct()
    {
        /** Категории*/

        $title_left = (config2('moonshine.useful_module.title_left')) ?? ' - ';
        $title_right = config2('moonshine.useful_module.title_right');

        $id_left = (config2('moonshine.useful_module.category_left')) ?? ' - ';
        $id_right = config2('moonshine.useful_module.category_right');

        $resultArrayLeft = [];
        $resultArrayRight = [];

        if ($id_left) {

            $rLeft = UseFulViewModel::make()->categoryId($id_left);

            foreach ($rLeft->subcategory as $category) {

                $i = 0;
                foreach ($category->item as $item) {
                    if($item) {
                        $resultArrayLeft[$i]['title'] = ($item->short_desc) ?: $item->title;
                        $resultArrayLeft[$i]['created_at'] = $item->created_at;
                        $resultArrayLeft[$i]['sorting'] = $item->sorting;
                        $resultArrayLeft[$i]['subcategory'] = $item->parent_subcategory;
                        $resultArrayLeft[$i]['url'] = $item->url;
                        $i++;
                    }
                }

            }


        }

        if ($id_right) {

            $rRight = UseFulViewModel::make()->categoryId($id_right);

            foreach ($rRight->subcategory as $category) {

                $i = 0;
                foreach ($category->item as $item) {
                    if($item) {
                        $resultArrayRight[$i]['title'] = ($item->short_desc) ?: $item->title;
                        $resultArrayRight[$i]['created_at'] = $item->created_at;
                        $resultArrayRight[$i]['sorting'] = $item->sorting;
                        $resultArrayRight[$i]['subcategory'] = $item->parent_subcategory;
                        $resultArrayRight[$i]['url'] = $item->url;
                        $i++;
                    }
                }

            }



        }

        $this->items['left']['title'] = $title_left;
        $this->items['left']['teasers'] = $resultArrayLeft;

        $this->items['right']['title'] = $title_right;
        $this->items['right']['teasers'] = $resultArrayRight;


        /** получаем текущий год*/
        $tax = TaxViewModel::make()->itemY(date("Y"));

        $this->mounth = strtolower(date('M'));
        $this->tax = $tax;


    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home.output-category-component');
    }
}
