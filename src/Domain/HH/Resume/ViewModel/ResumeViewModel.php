<?php

namespace Domain\HH\Resume\ViewModel;

use App\Models\HunterCategory;
use App\Models\HunterExperience;
use App\Models\HunterResumeItem;
use Domain\HH\Resume\DTOs\StoreResumeDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
     * Резюме конкретного пользователя с пагинацией
     */
    public function userResumes(int $userId): LengthAwarePaginator
    {
        return HunterResumeItem::query()
            ->where('user_id', $userId)
            ->orderBy('sorting', 'DESC')
            ->paginate(config('site.constants.paginate'));
    }

    /**
     * Количество резюме пользователя
     */
    public function countByUser(int $userId): int
    {
        return HunterResumeItem::where('user_id', $userId)->count();
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
     * Одна резюме по ID
     */
    public function resume(?int $id): ?Model
    {
        return HunterResumeItem::query()
            ->where('published', 1)
            ->where('id', $id)
            ->first();
    }

    /**
     * Создать резюме
     */
    public function create(StoreResumeDto $dto, int $userId): HunterResumeItem
    {
        DB::beginTransaction();

        try {
            $data = array_merge($dto->toArray(), [
                'user_id'   => $userId,
                'published' => 0,
                'sorting'   => (HunterResumeItem::max('sorting') ?? 0) + 10,
                'slug'      => Str::slug($dto->title) . '-' . Str::random(6),
            ]);

            $resume = HunterResumeItem::create($data);

            DB::commit();

            return $resume;

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

}
