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

        $footerMenu = MenuViewModel::make()->footerMenu();
        $menu =  [];
        $i = 0;
        /** проверим col1 на существование **/
        if (isset($footerMenu->col1) && count($footerMenu->col1) > 0) {

             $column = [];

                foreach ($footerMenu->col1 as $k => $col) {

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
        if (isset($footerMenu->col2) && count($footerMenu->col2) > 0) {

                $column = [];

                foreach ($footerMenu->col2 as $k => $col) {

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
        if (isset($footerMenu->col3) && count($footerMenu->col3) > 0) {

                $column = [];

                foreach ($footerMenu->col3 as $k => $col) {

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
        if (isset($footerMenu->col4) && count($footerMenu->col4) > 0) {

                $column = [];

                foreach ($footerMenu->col4 as $k => $col) {

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


        return $menu;
    }

    public function render(): View|Closure|string
    {
        return view('components.menu.footer-menu-component');
    }
}
