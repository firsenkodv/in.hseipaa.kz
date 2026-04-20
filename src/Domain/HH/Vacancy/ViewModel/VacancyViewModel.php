<?php

namespace Domain\HH\Vacancy\ViewModel;

use App\Models\HunterCategory;
use App\Models\HunterVacancyItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Makeable;

class VacancyViewModel
{
    use Makeable;

    /**
     * Категории вакансий для select-а
     */
    public function categories(): ?Collection
    {
        return HunterCategory::query()
            ->where('published', 1)
            ->orderBy('sorting', 'DESC')
            ->get();
    }

    /**
     * Все опубликованные вакансии с пагинацией
     */
    public function vacancies(): LengthAwarePaginator
    {
        return HunterVacancyItem::query()
            ->where('published', 1)
            ->orderBy('sorting', 'DESC')
            ->paginate(config('site.constants.paginate'));
    }

    /**
     * Поиск опубликованных вакансий по городу и категории с пагинацией
     */
    public function search(?int $cityId, ?int $categoryId): LengthAwarePaginator
    {
        return HunterVacancyItem::query()
            ->where('published', 1)
            ->when($cityId, fn($q) => $q->where('user_city_id', $cityId))
            ->when($categoryId, fn($q) => $q->where('hunter_category_id', $categoryId))
            ->orderBy('sorting', 'DESC')
            ->paginate(config('site.constants.paginate'));
    }
    /**
     * Одна вакансия по ID
     */
    public function vacancy(?int $id): ?Model
    {
        return HunterVacancyItem::query()
            ->where('published', 1)
            ->where('id', $id)
            ->first();
    }

}
