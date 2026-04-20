<?php

namespace Domain\HH\Vacancy\ViewModel;

use App\Models\HunterCategory;
use App\Models\HunterExperience;
use App\Models\HunterVacancyItem;
use Domain\HH\Vacancy\DTOs\StoreVacancyDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
     * Варианты опыта работы для select-а
     */
    public function experiences(): ?Collection
    {
        return HunterExperience::query()
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
     * Вакансии конкретного пользователя с пагинацией
     */
    public function userVacancies(int $userId): LengthAwarePaginator
    {
        return HunterVacancyItem::query()
            ->where('user_id', $userId)
            ->orderBy('sorting', 'DESC')
            ->paginate(config('site.constants.paginate'));
    }

    /**
     * Количество вакансий пользователя
     */
    public function countByUser(int $userId): int
    {
        return HunterVacancyItem::where('user_id', $userId)->count();
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

    /**
     * Создать вакансию
     */
    public function create(StoreVacancyDto $dto, int $userId, ?UploadedFile $logo = null): HunterVacancyItem
    {
        DB::beginTransaction();

        try {
            $data = array_merge($dto->toArray(), [
                'user_id'   => $userId,
                'published' => 0,
                'sorting'   => (HunterVacancyItem::max('sorting') ?? 0) + 10,
                'slug'      => Str::slug($dto->title) . '-' . Str::random(6),
            ]);

            if ($logo) {
                $data['logo'] = Storage::disk('public')->put('hunter/logos', $logo);
            }

            $vacancy = HunterVacancyItem::create($data);

            DB::commit();

            return $vacancy;

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

}
