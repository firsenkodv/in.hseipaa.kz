<?php

namespace App\View\Components\Menu;

use App\Enums\User\RegistryStatus;
use Closure;
use Domain\Company\ViewModel\CompanyViewModel;
use Domain\Service\ViewModels\ServiceViewModel;
use Domain\SiteNew\ViewModels\SiteNewViewModel;
use Domain\Tax\ViewModels\TaxViewModel;
use Domain\UseFul\ViewModels\UseFulViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderMenuComponent extends Component
{

    public string $menu;
    public $menu_rendered;

    public function __construct($menu = 1)
    {
        $this->menu = $menu;
        if ($this->menu == 1) {
            $this->menu_rendered = $this->setMenu1();
        }
        if ($this->menu == 2) {
            $this->menu_rendered = $this->setMenu2();
        }

    }

    public function setMenu1()
    {
        /** получаем текущий год*/
        $tax = TaxViewModel::make()->itemY(date("Y"));

        $i = 0;

        $menu[$i]['text'] = 'Календарь';
        $menu[$i]['link'] = route('tax_calendar', ['item_slug' => $tax->slug]);
        $menu[$i]['class'] = false;
        $menu[$i]['class_li'] = false;
        $menu[$i]['data'] = false;
        $menu[$i]['parent'] = false;
        $i++;

        $menu[$i]['text'] = 'Контакты';
        $menu[$i]['link'] = route('contacts');
        $menu[$i]['class'] = false;
        $menu[$i]['class_li'] = false;
        $menu[$i]['data'] = false;
        $menu[$i]['parent'] = false;
        $i++;

        $menu[$i]['text'] = 'Оформить подписку';
        $menu[$i]['link'] = '#';
        $menu[$i]['class'] = 'button_menu';
        $menu[$i]['class_li'] = false;
        $menu[$i]['data'] = false;
        $menu[$i]['parent'] = false;

        return $menu;
    }

    public function setMenu2()
    {

        $i = 0;

        /**  О нас **/

        $menu[$i]['text'] = config2('moonshine.company.title');
        $menu[$i]['link'] = config2('moonshine.company.slug');
        $menu[$i]['class'] = false;
        $menu[$i]['class_li'] = false;
        $menu[$i]['data'] = false;
        $menu[$i]['parent'] = true;
        $categories = CompanyViewModel::make()->categories();

        if ($categories) {
            foreach ($categories as $k => $category) {

                $menu[$i]['child'][$k]['link'] = config2('moonshine.company.slug') . '/' . $category->slug;
                $menu[$i]['child'][$k]['text'] = ($category->menu) ?? $category->title;
                $menu[$i]['child'][$k]['class'] = false;
                $menu[$i]['child'][$k]['class_li'] = false;
                $menu[$i]['child'][$k]['data'] = false;
            }

        }
        $i++;


        /**  ///О нас **/

        /**  Новости **/

        $menu[$i]['text'] = config2('moonshine.new.title');
        $menu[$i]['link'] = config2('moonshine.new.slug');
        $menu[$i]['class'] = false;
        $menu[$i]['class_li'] = false;
        $menu[$i]['data'] = false;
        $categories = SiteNewViewModel::make()->categories();
        $menu[$i]['parent'] = (bool)count($categories);;

        if ($categories) {
            foreach ($categories as $k => $category) {

                $menu[$i]['child'][$k]['link'] = config2('moonshine.new.slug') . '/' . $category->slug;
                $menu[$i]['child'][$k]['text'] = ($category->menu) ?? $category->title;
                $menu[$i]['child'][$k]['class'] = false;
                $menu[$i]['child'][$k]['class_li'] = false;
                $menu[$i]['child'][$k]['data'] = false;
            }

        }
        $i++;


        /**  ///Новости **/
        /**  Полезное **/

        $sections = UseFulViewModel::make()->sections();
        if (count($sections)) {
            foreach ($sections as $key => $section) {
                $menu[$i]['text'] = ($section->menu) ?? $section->title;;
                $menu[$i]['link'] = 'section-' . $section->slug;
                $menu[$i]['class'] = false;
                $menu[$i]['class_li'] = false;
                $menu[$i]['data'] = false;
                $menu[$i]['parent'] = (bool)count($section->category);

                if (count($section->category)) {
                    foreach ($section->category as $k => $category) {

                        $menu[$i]['child'][$k]['link'] = 'section-' . $section->slug . "/" . $category->slug;
                        $menu[$i]['child'][$k]['text'] = ($category->menu) ?? $category->title;;
                        $menu[$i]['child'][$k]['class'] = false;
                        $menu[$i]['child'][$k]['class_li'] = false;
                        $menu[$i]['child'][$k]['data'] = false;
                    }

                }
                $i++;
            }
        }

        /**  ///Полезное **/
        /**  Услуги **/

        $sections = ServiceViewModel::make()->sections();
        if (count($sections)) {
            foreach ($sections as $key => $section) {
                $menu[$i]['text'] = ($section->menu) ?? $section->title;
                $menu[$i]['link'] = '/service-' . $section->slug;
                $menu[$i]['class'] = false;
                $menu[$i]['class_li'] = false;
                $menu[$i]['data'] = false;
                $menu[$i]['parent'] = (bool)count($section->category);

                if (count($section->category)) {
                    foreach ($section->category as $k => $category) {

                        $menu[$i]['child'][$k]['link'] = 'service-' . $section->slug . "/" . $category->slug;
                        $menu[$i]['child'][$k]['text'] = ($category->menu) ?? $category->title;
                        $menu[$i]['child'][$k]['class'] = false;
                        $menu[$i]['child'][$k]['class_li'] = false;
                        $menu[$i]['child'][$k]['data'] = false;
                    }

                }
                $i++;
            }
        }
        /**  ///Услуги **/

        /**  Реестр **/
        $menu[$i]['text'] = 'Реестр';
        $menu[$i]['link'] = route('registry');
        $menu[$i]['class'] = '';
        $menu[$i]['class_li'] = false;
        $menu[$i]['data'] = false;
        $menu[$i]['parent'] = true;

        $menu[$i]['child'][0]['link'] = route('registry_specialists');
        $menu[$i]['child'][0]['text'] = RegistryStatus::SPECIALIST->text();
        $menu[$i]['child'][0]['class'] = false;
        $menu[$i]['child'][0]['class_li'] = false;
        $menu[$i]['child'][0]['data'] = false;

        $menu[$i]['child'][1]['link'] = route('registry_experts');
        $menu[$i]['child'][1]['text'] = RegistryStatus::EXPERT->text();
        $menu[$i]['child'][1]['class'] = false;
        $menu[$i]['child'][1]['class_li'] = false;
        $menu[$i]['child'][1]['data'] = false;

        $menu[$i]['child'][2]['link'] = route('registry_legal_entities');
        $menu[$i]['child'][2]['text'] = RegistryStatus::LEGALENTITY->text();
        $menu[$i]['child'][2]['class'] = false;
        $menu[$i]['child'][2]['class_li'] = false;
        $menu[$i]['child'][2]['data'] = false;
        /**  ///Реестр **/
        $i++;
        /**  Контакты **/
        $menu[$i]['text'] = 'Контакты';
        $menu[$i]['link'] = route('contacts');
        $menu[$i]['class'] = '';
        $menu[$i]['class_li'] = false;
        $menu[$i]['data'] = false;
        $menu[$i]['parent'] = false;
        /**  ///Контакты **/

        return $menu;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.header-menu-component');
    }
}
