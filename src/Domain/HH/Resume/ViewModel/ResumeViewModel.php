<?php

namespace Domain\HH\Resume\ViewModel;

use App\Models\HunterCategory;
use App\Models\HunterResumeItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Makeable;

class ResumeViewModel
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
     * Все опубликованные резюме с пагинацией
     */
    public function resumes(): LengthAwarePaginator
    {
        return HunterResumeItem::query()
            ->where('published', 1)
            ->orderBy('sorting', 'DESC')
            ->paginate(config('site.constants.paginate'));
    }

    /**
     * Поиск опубликованных резюме по городу и категории с пагинацией
     */
    public function search(?int $cityId, ?int $categoryId): LengthAwarePaginator
    {
        return HunterResumeItem::query()
            ->where('published', 1)
            ->when($cityId, fn($q) => $q->where('user_city_id', $cityId))
            ->when($categoryId, fn($q) => $q->where('hunter_category_id', $categoryId))
            ->orderBy('sorting', 'DESC')
            ->paginate(config('site.constants.paginate'));
    }
    /**
     * Одна резюме по ID
     */
    public function resume(?int $id): ?Model
    {
        return HunterResumeItem::query()
            ->where('published', 1)
            ->where('id', $id)
            ->first();
    }

}
