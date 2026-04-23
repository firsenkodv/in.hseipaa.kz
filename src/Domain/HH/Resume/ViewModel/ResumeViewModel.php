<?php

namespace Domain\HH\Resume\ViewModel;

use App\Enums\HH\ResumeArchiveEnum;
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
     * Города, которые фактически используются в опубликованных резюме
     */
    public function cities(): array
    {
        return HunterResumeItem::query()
            ->with('city')
            ->where('published', 1)
            ->where('archive', ResumeArchiveEnum::NOTARCHIVED->value)
            ->whereNotNull('user_city_id')
            ->get()
            ->pluck('city')
            ->filter()
            ->unique('id')
            ->map(fn($city) => ['id' => $city->id, 'title' => $city->title])
            ->values()
            ->toArray();
    }

    /**
     * Все опубликованные резюме с пагинацией
     */
    public function resumes(): LengthAwarePaginator
    {
        return HunterResumeItem::query()
            ->where('published', 1)
            ->where('archive', ResumeArchiveEnum::NOTARCHIVED->value)
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
            ->where('archive', ResumeArchiveEnum::NOTARCHIVED->value)
            ->when($cityId, fn($q) => $q->where('user_city_id', $cityId))
            ->when($categoryId, fn($q) => $q->where('hunter_category_id', $categoryId))
            ->orderBy('sorting', 'DESC')
            ->paginate(config('site.constants.paginate'));
    }

    /**
     * Резюме конкретного пользователя с пагинацией (не в архиве)
     */
    public function userResumes(int $userId): LengthAwarePaginator
    {
        return HunterResumeItem::query()
            ->where('user_id', $userId)
            ->where('archive', ResumeArchiveEnum::NOTARCHIVED->value)
            ->orderBy('sorting', 'DESC')
            ->paginate(config('site.constants.paginate'));
    }

    /**
     * Количество активных резюме пользователя (не в архиве)
     */
    public function countByUser(int $userId): int
    {
        return HunterResumeItem::where('user_id', $userId)->where('archive', ResumeArchiveEnum::NOTARCHIVED->value)->count();
    }

    /**
     * Архивные резюме пользователя с пагинацией
     */
    public function userResumesArchive(int $userId): LengthAwarePaginator
    {
        return HunterResumeItem::query()
            ->where('user_id', $userId)
            ->where('archive', ResumeArchiveEnum::ARCHIVE->value)
            ->orderBy('sorting', 'DESC')
            ->paginate(config('site.constants.paginate'));
    }

    /**
     * Количество архивных резюме пользователя
     */
    public function countArchiveByUser(int $userId): int
    {
        return HunterResumeItem::where('user_id', $userId)->where('archive', ResumeArchiveEnum::ARCHIVE->value)->count();
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
     * Одна резюме по ID (только опубликованные — публичная страница)
     */
    public function resume(?int $id): ?Model
    {
        return HunterResumeItem::query()
            ->where('published', 1)
            ->where('id', $id)
            ->first();
    }

    /**
     * Резюме пользователя по ID (без фильтра по published — для личного кабинета)
     */
    public function userResume(int $id, int $userId): ?Model
    {
        return HunterResumeItem::query()
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * Архивное резюме пользователя по ID
     */
    public function userResumeArchive(int $id, int $userId): ?Model
    {
        return HunterResumeItem::query()
            ->where('id', $id)
            ->where('user_id', $userId)
            ->where('archive', ResumeArchiveEnum::ARCHIVE->value)
            ->first();
    }

    /**
     * Обновить существующее резюме пользователя
     */
    public function update(int $id, int $userId, StoreResumeDto $dto): HunterResumeItem
    {
        $resume = HunterResumeItem::where('id', $id)->where('user_id', $userId)->firstOrFail();

        DB::beginTransaction();

        try {
            $resume->update($dto->toArray());

            DB::commit();

            return $resume;

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Переместить резюме пользователя в архив
     */
    public function moveToArchive(int $id, int $userId): void
    {
        HunterResumeItem::where('id', $id)
            ->where('user_id', $userId)
            ->where('archive', ResumeArchiveEnum::NOTARCHIVED->value)
            ->firstOrFail()
            ->update(['archive' => ResumeArchiveEnum::ARCHIVE->value]);
    }

    /**
     * Восстановить резюме из архива
     */
    public function restoreFromArchive(int $id, int $userId): void
    {
        HunterResumeItem::where('id', $id)
            ->where('user_id', $userId)
            ->where('archive', ResumeArchiveEnum::ARCHIVE->value)
            ->firstOrFail()
            ->update([
                'archive'    => ResumeArchiveEnum::NOTARCHIVED->value,
                'expired_at' => now()->addDays(30)->toDateString(),
            ]);
    }

    /**
     * Удалить резюме пользователя
     */
    public function delete(int $id, int $userId): void
    {
        $resume = HunterResumeItem::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $resume->delete();
    }

    /**
     * Создать резюме
     */
    public function create(StoreResumeDto $dto, int $userId): HunterResumeItem
    {
        DB::beginTransaction();

        try {
            $data = array_merge($dto->toArray(), [
                'user_id'    => $userId,
                'published'  => 0,
                'sorting'    => (HunterResumeItem::max('sorting') ?? 0) + 10,
                'slug'       => Str::slug($dto->title) . '-' . Str::random(6),
                'expired_at' => now()->addDays(30)->toDateString(),
                'archive'    => ResumeArchiveEnum::NOTARCHIVED->value,
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
