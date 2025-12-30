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
            if (count($footerMenu->col1)) {
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

            if (count($footerMenu->col2)) {

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

            if (count($footerMenu->col3)) {

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
            if (count($footerMenu->col4)) {

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
