<?php

namespace Domain\ROP\ViewModels;


use App\Models\Manager;
use App\Models\ROP;
use App\Models\User;
use Domain\ROP\DTOs\RopUpdateDto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
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
     * @return array|LengthAwarePaginator
     */
    public function ropUserList($r): array|LengthAwarePaginator
    {
        $ids = Manager::query()
            ->select('id')
            ->where('r_o_p_id', $r->id)
            ->pluck('id');

        if (count($ids)) {

            return User::query()
                ->whereIn('manager_id', $ids)
                ->with(['UserHuman', 'UserLecturer', 'UserCity', 'UserExpert', 'UserSex', 'UserProduction', 'UserSpecialist', 'UserLanguage', 'Tarif', 'Manager'])
                ->orderBy('created_at', 'desc')
                ->paginate(config('site.constants.paginate'));

        }
        return [];

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
        $manager = $user->Manager;
        if ($manager->r_o_p_id != $rop_id) {
            abort(404);
        }

        return $user;

    }

}
