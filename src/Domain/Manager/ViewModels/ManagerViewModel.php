<?php

namespace Domain\Manager\ViewModels;


use App\Enums\Moonshine\StatusManagerEnum;
use App\Enums\User\MarkedDeleteEnum;
use App\Models\Manager;
use App\Models\User;
use Domain\Manager\DTOs\ManagerDto;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Support\Traits\Makeable;
use Throwable;

class ManagerViewModel
{
    use Makeable;

    /**
     * @param $request
     * @return mixed|null
     * Получим менеджеров из $request
     */
    public function manager($request): model|null
    {
        return Manager::query()
            ->where('email', $request->email)
            ->where('password', $request->password)
            ->first();
    }

    /**
     * @param $email
     * @return mixed|null
     * Получим менеджера по email
     */
    public function m($email): model|null
    {
        return Manager::query()
            ->where('email', $email)
            ->first();
    }

    /**
     * @param $id
     * @return Manager|Model
     * менеджер по id
     */
    public function managerId($id): ?Model
    {
        return Manager::query()
            ->where('id', $id)
            ->first();
    }

    /**
     * @param $request
     * @return bool
     * @throws Throwable
     */

    public function updatePersonalDataManager($request): bool
    {

        $data = ManagerDto::formRequest($request);

        /** Сначала получаем пользователя по указанному ID **/
        $manager = Manager::query()->where('id', $request->manager_id)->first();

        if (!$manager) {
            throw new \Exception("Пользователь с указанным ID не найден.");
        }

        \DB::beginTransaction(); // Начинаем транзакцию

        try {
            /** Обновляем основного пользователя **/
            $manager->update($data->toArray());

            \DB::commit(); // Подтверждение успешной транзакции
        } catch (Throwable $exception) {
            \DB::rollBack(); // Откат транзакции в случае ошибки
            logErrors($exception);
            throw $exception; // Повторно выбрасываем исключение вверх по стеку

        }

        return true;

    }


    public function addPersonalDataManager($request): ?Manager
    {
        $data = ManagerDto::formRequest($request);
        return Manager::Create($data->toArray());

    }

    public function mainManager(): ?Manager
    {
        return Manager::query()->where('main', StatusManagerEnum::MAIN->value)->first();

    }


    public function assignUsers(int $manager_id, array $users):?int
    {
       return User::whereIn('id', $users)->update([
            'manager_id' => $manager_id
        ]);

    }

    /**
     * Список пользователей данного менеджера
     */
    public function managerUserList($m, string $locked = ''): array|LengthAwarePaginator
    {
        $q = User::query();
        $q->where('manager_id', $m->id)
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

    /**
     * Пользователь по id, закреплённый за данным менеджером
     */
    public function managerUserId(int $id, int $manager_id): ?Model
    {
        return User::query()
            ->where('id', $id)
            ->where('manager_id', $manager_id)
            ->firstOrFail();
    }
}
