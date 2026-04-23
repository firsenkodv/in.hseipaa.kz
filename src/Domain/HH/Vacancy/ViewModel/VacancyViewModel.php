<?php

namespace Domain\HH\Vacancy\ViewModel;

use App\Enums\HH\VacancyArchiveEnum;
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
     * Города, которые фактически используются в опубликованных вакансиях
     */
    public function cities(): array
    {
        return HunterVacancyItem::query()
            ->with('city')
            ->where('published', 1)
            ->where('archive', VacancyArchiveEnum::NOTARCHIVED->value)
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
     * Все опубликованные вакансии с пагинацией
     */
    public function vacancies(): LengthAwarePaginator
    {
        return HunterVacancyItem::query()
            ->where('published', 1)
            ->where('archive', VacancyArchiveEnum::NOTARCHIVED->value)
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
            ->where('archive', VacancyArchiveEnum::NOTARCHIVED->value)
            ->when($cityId, fn($q) => $q->where('user_city_id', $cityId))
            ->when($categoryId, fn($q) => $q->where('hunter_category_id', $categoryId))
            ->orderBy('sorting', 'DESC')
            ->paginate(config('site.constants.paginate'));
    }
    /**
     * Вакансии конкретного пользователя с пагинацией (не в архиве)
     */
    public function userVacancies(int $userId): LengthAwarePaginator
    {
        return HunterVacancyItem::query()
            ->where('user_id', $userId)
            ->where('archive', VacancyArchiveEnum::NOTARCHIVED->value)
            ->orderBy('sorting', 'DESC')
            ->paginate(config('site.constants.paginate'));
    }

    /**
     * Количество активных вакансий пользователя (не в архиве)
     */
    public function countByUser(int $userId): int
    {
        return HunterVacancyItem::where('user_id', $userId)->where('archive', VacancyArchiveEnum::NOTARCHIVED->value)->count();
    }

    /**
     * Архивные вакансии пользователя с пагинацией
     */
    public function userVacanciesArchive(int $userId): LengthAwarePaginator
    {
        return HunterVacancyItem::query()
            ->where('user_id', $userId)
            ->where('archive', VacancyArchiveEnum::ARCHIVE->value)
            ->orderBy('sorting', 'DESC')
            ->paginate(config('site.constants.paginate'));
    }

    /**
     * Количество архивных вакансий пользователя
     */
    public function countArchiveByUser(int $userId): int
    {
        return HunterVacancyItem::where('user_id', $userId)->where('archive', VacancyArchiveEnum::ARCHIVE->value)->count();
    }

    /**
     * Одна вакансия по ID (только опубликованные — публичная страница)
     */
    public function vacancy(?int $id): ?Model
    {
        return HunterVacancyItem::query()
            ->where('published', 1)
            ->where('id', $id)
            ->first();
    }

    /**
     * Вакансия пользователя по ID (без фильтра по published — для личного кабинета)
     */
    public function userVacancy(int $id, int $userId): ?Model
    {
        return HunterVacancyItem::query()
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * Архивная вакансия пользователя по ID
     */
    public function userVacancyArchive(int $id, int $userId): ?Model
    {
        return HunterVacancyItem::query()
            ->where('id', $id)
            ->where('user_id', $userId)
            ->where('archive', VacancyArchiveEnum::ARCHIVE->value)
            ->first();
    }

    /**
     * Обновить существующую вакансию пользователя
     */
    public function update(int $id, int $userId, StoreVacancyDto $dto, ?UploadedFile $logo = null, bool $removeLogo = false): HunterVacancyItem
    {
        $vacancy = HunterVacancyItem::where('id', $id)->where('user_id', $userId)->firstOrFail();

        DB::beginTransaction();

        try {
            $data = $dto->toArray();

            if ($logo) {
                if ($vacancy->logo) {
                    Storage::disk('public')->delete($vacancy->logo);
                }
                $data['logo'] = Storage::disk('public')->put('hunter/logos', $logo);
            } elseif ($removeLogo && $vacancy->logo) {
                Storage::disk('public')->delete($vacancy->logo);
                $data['logo'] = null;
            }

            $vacancy->update($data);

            DB::commit();

            return $vacancy;

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Переместить вакансию пользователя в архив
     */
    public function moveToArchive(int $id, int $userId): void
    {
        HunterVacancyItem::where('id', $id)
            ->where('user_id', $userId)
            ->where('archive', VacancyArchiveEnum::NOTARCHIVED->value)
            ->firstOrFail()
            ->update(['archive' => VacancyArchiveEnum::ARCHIVE->value]);
    }

    /**
     * Восстановить вакансию из архива
     */
    public function restoreFromArchive(int $id, int $userId): void
    {
        HunterVacancyItem::where('id', $id)
            ->where('user_id', $userId)
            ->where('archive', VacancyArchiveEnum::ARCHIVE->value)
            ->firstOrFail()
            ->update([
                'archive'    => VacancyArchiveEnum::NOTARCHIVED->value,
                'expired_at' => now()->addDays(30)->toDateString(),
            ]);
    }

    /**
     * Удалить вакансию пользователя
     */
    public function delete(int $id, int $userId): void
    {
        $vacancy = HunterVacancyItem::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $vacancy->delete();
    }

    /**
     * Создать вакансию
     */
    public function create(StoreVacancyDto $dto, int $userId, ?UploadedFile $logo = null): HunterVacancyItem
    {
        DB::beginTransaction();

        try {
            $data = array_merge($dto->toArray(), [
                'user_id'    => $userId,
                'published'  => 0,
                'sorting'    => (HunterVacancyItem::max('sorting') ?? 0) + 10,
                'slug'       => Str::slug($dto->title) . '-' . Str::random(6),
                'expired_at' => now()->addDays(30)->toDateString(),
                'archive'    => VacancyArchiveEnum::NOTARCHIVED->value,
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
