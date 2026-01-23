<?php

namespace App\View\Components\Content;

use App\Enums\User\RegistryStatus;
use Closure;
use Domain\City\ViewModels\CityViewModel;
use Domain\UserExpert\ViewModels\UserExpertViewModel;
use Domain\UserSpecialist\ViewModels\UserSpecialistViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContentRegistrySearchComponent extends Component
{

    public array $select = [];
    public string $placeholder;
    public string $name;
    public array $cities = [];
    public string $route;
    public array $fields;

    public function __construct($registry, $fields)
    {

        $method = match ($registry) {
            RegistryStatus::SPECIALIST->value => 'renderSpecialists',
            RegistryStatus::EXPERT->value => 'renderExperts',
        };

        $this->select = $this->$method();
        $this->cities = $this->renderCities();
        $this->fields = $fields;
    }

    /**
     *
     */
    public function renderSpecialists():array
    {
        $specialists = UserSpecialistViewModel::make()->Specialists();

        if ($specialists->isEmpty()) { // Проверяем, пуста ли коллекция
            return [];
        }

        $this->placeholder = 'Выберите специалиста';
        $this->name = 'specialist';
        $this->route = 'registry_specialists';

        // Преобразуем коллекцию в массив
        $arrSpecialists = $specialists->toArray();

        // Добавляем элемент в начало массива
        array_unshift($arrSpecialists,  ['id' => '0', 'title' => 'Все']);

        // Теперь первым элементом массива будет пара ['0'=>'Все']
        return $arrSpecialists;

    }

    public function renderExperts():array
    {
        $experts =  UserExpertViewModel::make()->Experts();
        if ($experts->isEmpty()) { // Проверяем, пуста ли коллекция
            return [];
        }
        $this->placeholder = 'Выберите эксперта';
        $this->name = 'expert';
        $this->route = 'registry_experts';

        // Преобразуем коллекцию в массив
        $arrExperts = $experts->toArray();

        // Добавляем элемент в начало массива
        array_unshift($arrExperts, ['id' => '0', 'title' => 'Все']);

        // Теперь первым элементом массива будет пара ['0'=>'Все']
        return $arrExperts;
    }

    public function renderCities():array
    {
        $cities = CityViewModel::make()->Cities();
        if ($cities->isEmpty()) { // Проверяем, пуста ли коллекция
            return [];
        }

        // Преобразуем коллекцию в массив
        $arrCities = $cities->toArray();

        // Добавляем элемент в начало массива
        array_unshift($arrCities, ['id' => '0', 'title' => 'Все']);

        // Теперь первым элементом массива будет пара ['0'=>'Все']
        return $arrCities;
    }

    public function render(): View|Closure|string
    {
        return view('components.content.content-registry-search-component');
    }
}
