<?php

namespace Domain\ROP\ViewModels;


use App\Enums\User\MarkedDeleteEnum;
use App\Models\HunterResumeItem;
use App\Models\HunterVacancyItem;
use App\Models\Manager;
use App\Models\ROP;
use App\Models\User;
use Domain\Manager\ViewModels\ManagerViewModel;
use Domain\ROP\DTOs\RopUpdateDto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;
use Support\Traits\Makeable;
use Support\Traits\Upload;
use Throwable;

class ROPViewModel
{
    use Makeable;
    use Upload;

    /**
     * @param $request
     * @return mixed|null
     * Получим менеджер из $request
     */
    public function ROP($request): model|null
    {
        return ROP::query()
            ->where('email', $request->email)
            ->where('password', trim($request->password))
            ->first();
    }

    /**
     * @param $email
     * @return mixed|null
     * получим РОП по email
     */
    public function r($email): model|null
    {
        return ROP::query()
            ->where('email', $email)
            ->with('manager')
            ->first();
    }

    /**
     * @param $request
     * @param $id
     * @return bool
     * @throws Throwable
     */

    public function updatePersonalDataRop($request, $id): bool
    {

        $data = ROPUpdateDto::formRequest($request);

        /** Сначала получаем пользователя по указанному ID **/
        $rop = ROP::query()->where('id', $id)->first();

        if (!$rop) {
            throw new \Exception("Пользователь с указанным ID не найден.");
        }

        \DB::beginTransaction(); // Начинаем транзакцию

        try {
            /** Обновляем основного пользователя **/
            $rop->update($data->toArray());

            \DB::commit(); // Подтверждение успешной транзакции
        } catch (Throwable $exception) {
            \DB::rollBack(); // Откат транзакции в случае ошибки
            logErrors($exception);
            throw $exception; // Повторно выбрасываем исключение вверх по стеку

        }

        return true;

    }


    /**
     * Все менеджеры данного РОП
     */

    public function ropManagerListPaginate($r): ?LengthAwarePaginator
    {

        return Manager::query()->where('r_o_p_id', $r->id)
            ->orderBy('created_at', 'desc')
            ->paginate(config('site.constants.paginate'));

    }

    public function ropManagerList($r): ?Collection
    {

        return Manager::query()->where('r_o_p_id', $r->id)
            ->orderBy('created_at', 'desc')
            ->get();

    }

    public function ropManagerListMap($r): ?array
    {

        return Manager::query()
            ->where('r_o_p_id', $r->id)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'title' => $item['username']
                ];

            })->toArray();
    }


    /**
     * @param $id
     * @param $rop_id
     * @return Manager|Model
     * Привязан к определенному РОП и по id
     */
    public function ropManagerId($id, $rop_id): ?Model
    {
        return Manager::query()
            ->where('id', $id)
            ->where('r_o_p_id', $rop_id)
            ->firstOrFail();
    }


    /**
     * @param $r
     * @param string $locked
     * @return array|LengthAwarePaginator
     */
    public function ropUserList($r, string $locked =  ''): array|LengthAwarePaginator
    {
        $ids = Manager::query()
            ->select('id')
            ->where('r_o_p_id', $r->id)
            ->pluck('id');

        if (count($ids)) {

            $q =  User::query();
                $q->whereIn('manager_id', $ids)
                ->with(['UserHuman', 'UserLecturer', 'UserCity', 'UserExpert', 'UserSex', 'UserProduction', 'UserSpecialist', 'UserLanguage', 'Tarif', 'Manager']);
                if ($locked === 'deleted') {
                    $q->where('marked_delete', MarkedDeleteEnum::MARKED->value);
                } elseif ($locked) {
                    $q->where('published', 0)
                      ->where('marked_delete', '!=', MarkedDeleteEnum::MARKED->value);
                }
               return $q->orderByDesc(function ($query) {
                        $query->selectRaw('COUNT(*)')
                            ->from('cabinet_messages')
                            ->join('cabinet_conversations', 'cabinet_messages.cabinet_conversation_id', '=', 'cabinet_conversations.id')
                            ->whereColumn('cabinet_conversations.user_id', 'users.id')
                            ->where('cabinet_messages.sender_type', \App\Models\User::class)
                            ->whereNull('cabinet_messages.read_at');
                    })
                    ->orderBy('updated_at', 'desc')
                    ->paginate(config('site.constants.paginate'));


        }
        return [];

    }

    /**
     * @param $r
     * @param string $locked
     * @return ?Collection
     */
    public function ropUserListCount($r, string $locked =  ''): ?Collection
    {
        $ids = Manager::query()
            ->select('id')
            ->where('r_o_p_id', $r->id)
            ->pluck('id');

        if (count($ids)) {

            $q =  User::query();
                $q->whereIn('manager_id', $ids)
                ->with(['UserHuman', 'UserLecturer', 'UserCity', 'UserExpert', 'UserSex', 'UserProduction', 'UserSpecialist', 'UserLanguage', 'Tarif', 'Manager']);
                if($locked) {
                    $q->where('published', 0);
                }
               return $q->get();



        }
        return null;

    }


    /**
     * @param $id
     * @return null| LengthAwarePaginator
     */
    public function ropUserListSearch($id):?LengthAwarePaginator
    {
        return User::query()->where('manager_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(config('site.constants.paginate'));

    }

    /**
     * Все ID пользователей, принадлежащих менеджерам данного РОП
     */
    public function ropUserIds($r): SupportCollection
    {
        $managerIds = Manager::query()
            ->select('id')
            ->where('r_o_p_id', $r->id)
            ->pluck('id');

        if ($managerIds->isEmpty()) {
            return collect();
        }

        return User::query()
            ->whereIn('manager_id', $managerIds)
            ->pluck('id');
    }

    /**
     * Количество всех вакансий пользователей РОП
     */
    public function ropVacancyCount($r): int
    {
        $userIds = $this->ropUserIds($r);
        if ($userIds->isEmpty()) return 0;
        return HunterVacancyItem::whereIn('user_id', $userIds)->count();
    }

    /**
     * Количество неопубликованных вакансий пользователей РОП
     */
    public function ropVacancyUnpublishedCount($r): int
    {
        $userIds = $this->ropUserIds($r);
        if ($userIds->isEmpty()) return 0;
        return HunterVacancyItem::whereIn('user_id', $userIds)->where('published', 0)->count();
    }

    /**
     * Количество всех резюме пользователей РОП
     */
    public function ropResumeCount($r): int
    {
        $userIds = $this->ropUserIds($r);
        if ($userIds->isEmpty()) return 0;
        return HunterResumeItem::whereIn('user_id', $userIds)->count();
    }

    /**
     * Количество неопубликованных резюме пользователей РОП
     */
    public function ropResumeUnpublishedCount($r): int
    {
        $userIds = $this->ropUserIds($r);
        if ($userIds->isEmpty()) return 0;
        return HunterResumeItem::whereIn('user_id', $userIds)->where('published', 0)->count();
    }

    /**
     * Города, которые фактически используются в вакансиях пользователей РОП
     */
    public function ropVacancyCities($r, bool $moderation = false): array
    {
        $userIds = $this->ropUserIds($r);
        if ($userIds->isEmpty()) return [];

        $q = HunterVacancyItem::query()
            ->with('city')
            ->whereIn('user_id', $userIds)
            ->whereNotNull('user_city_id');

        if ($moderation) {
            $q->where('published', 0);
        }

        return $q->get()
            ->pluck('city')
            ->filter()
            ->unique('id')
            ->map(fn($city) => ['id' => $city->id, 'title' => $city->title])
            ->values()
            ->toArray();
    }

    /**
     * Города, которые фактически используются в резюме пользователей РОП
     */
    public function ropResumeCities($r, bool $moderation = false): array
    {
        $userIds = $this->ropUserIds($r);
        if ($userIds->isEmpty()) return [];

        $q = HunterResumeItem::query()
            ->with('city')
            ->whereIn('user_id', $userIds)
            ->whereNotNull('user_city_id');

        if ($moderation) {
            $q->where('published', 0);
        }

        return $q->get()
            ->pluck('city')
            ->filter()
            ->unique('id')
            ->map(fn($city) => ['id' => $city->id, 'title' => $city->title])
            ->values()
            ->toArray();
    }

    /**
     * Список вакансий пользователей РОП (все или только неопубликованные).
     * Опционально фильтрация по городу и категории.
     */
    public function ropVacancyList($r, bool $moderation = false, ?int $cityId = null, ?int $categoryId = null): LengthAwarePaginator|array
    {
        $userIds = $this->ropUserIds($r);
        if ($userIds->isEmpty()) return [];

        $q = HunterVacancyItem::query()
            ->with(['user', 'category', 'city'])
            ->whereIn('user_id', $userIds);

        if ($moderation) {
            $q->where('published', 0);
        }

        $q->when($cityId, fn($q) => $q->where('user_city_id', $cityId))
          ->when($categoryId, fn($q) => $q->where('hunter_category_id', $categoryId));

        return $q->orderBy('sorting', 'desc')
            ->paginate(config('site.constants.paginate'));
    }

    /**
     * Список резюме пользователей РОП (все или только неопубликованные).
     * Опционально фильтрация по городу и категории.
     */
    public function ropResumeList($r, bool $moderation = false, ?int $cityId = null, ?int $categoryId = null): LengthAwarePaginator|array
    {
        $userIds = $this->ropUserIds($r);
        if ($userIds->isEmpty()) return [];

        $q = HunterResumeItem::query()
            ->with(['user', 'category', 'city'])
            ->whereIn('user_id', $userIds);

        if ($moderation) {
            $q->where('published', 0);
        }

        $q->when($cityId, fn($q) => $q->where('user_city_id', $cityId))
          ->when($categoryId, fn($q) => $q->where('hunter_category_id', $categoryId));

        return $q->orderBy('sorting', 'desc')
            ->paginate(config('site.constants.paginate'));
    }

    /**
     * @param $id
     * @param $rop_id
     * @return Model|null
     * пользователь закреплен за РОП
     */
    public function ropUserId($id, $rop_id): ?Model
    {
        $user = User::query()
            ->where('id', $id)
            ->firstOrFail();
        // если у пользователя нет менеджера
        if(is_null($user->Manager)) {

            $manager = ManagerViewModel::make()->mainManager();
            if (!is_null($manager)){
                if ($manager->r_o_p_id != $rop_id) {
                    abort(404);
                }
                return $user;

            }
            //main
        }

        // у пользователя есть менеджер
//        dd($user->Manager->r_o_p_id);

        // если менеджер не закреплен за РОП
        if (!is_null($user->Manager->r_o_p_id) and $user->Manager->r_o_p_id != $rop_id) {
            abort(404);
        }

        return $user;

    }

}
