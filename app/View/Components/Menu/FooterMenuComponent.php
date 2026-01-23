<?php

namespace App\View\Components\Menu;

use Closure;
use Domain\Menu\ViewModels\MenuViewModel;
use Domain\Tax\ViewModels\TaxViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FooterMenuComponent extends Component
{

    public array $menu_rendered;

    public function __construct()
    {
        $this->menu_rendered = $this->setMenu();

    }

    public function setMenu():array
    {

        /**  Нижнее меню ID - 1 выводится в ручную!  */
        $mainMenuItems = MenuViewModel::make()->footerMenu();
        $menu =  [];
        $i = 0;
        /** проверим col1 на существование **/
        if (isset($mainMenuItems->col1) && count($mainMenuItems->col1) > 0) {

             $column = [];

                foreach ($mainMenuItems->col1 as $k => $col) {

                    $column[$k]['text'] = $col['json_text'];
                    $column[$k]['link'] = ($col['json_url'])??'#';
                    $column[$k]['class'] = false;
                    $column[$k]['class_li'] = false;
                    $column[$k]['data'] = false;
                    $column[$k]['parent'] = false;
                }

                $menu[$i] =  $column;
                $i++;

            }
        /** проверим col2 на существование **/
        if (isset($mainMenuItems->col2) && count($mainMenuItems->col2) > 0) {

                $column = [];

                foreach ($mainMenuItems->col2 as $k => $col) {

                    $column[$k]['text'] = $col['json_text'];
                    $column[$k]['link'] = ($col['json_url'])??'#';
                    $column[$k]['class'] = false;
                    $column[$k]['class_li'] = false;
                    $column[$k]['data'] = false;
                    $column[$k]['parent'] = false;
                }

                $menu[$i] =  $column;
                $i++;

            }
        /** проверим col3 на существование **/
        if (isset($mainMenuItems->col3) && count($mainMenuItems->col3) > 0) {

                $column = [];

                foreach ($mainMenuItems->col3 as $k => $col) {

                    $column[$k]['text'] = $col['json_text'];
                    $column[$k]['link'] = ($col['json_url'])??'#';
                    $column[$k]['class'] = false;
                    $column[$k]['class_li'] = false;
                    $column[$k]['data'] = false;
                    $column[$k]['parent'] = false;
                }

                $menu[$i] =  $column;
                $i++;

            }
        /** проверим col4 на существование **/
        if (isset($mainMenuItems->col4) && count($mainMenuItems->col4) > 0) {

                $column = [];

                foreach ($mainMenuItems->col4 as $k => $col) {

                    $column[$k]['text'] = $col['json_text'];
                    $column[$k]['link'] = ($col['json_url'])??'#';
                    $column[$k]['class'] = false;
                    $column[$k]['class_li'] = false;
                    $column[$k]['data'] = false;
                    $column[$k]['parent'] = false;
                }

                $menu[$i] =  $column;
                $i++;

            }

        /** return */
        return $menu;
    }

    public function render(): View|Closure|string
    {
        return view('components.menu.footer-menu-component');
    }
}
