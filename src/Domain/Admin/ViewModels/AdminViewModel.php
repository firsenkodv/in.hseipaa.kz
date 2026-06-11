<?php

namespace Domain\Admin\ViewModels;


use App\Models\Admin;
use App\Models\User;
use Domain\Admin\DTOs\AdminUpdateDto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Support\Traits\Makeable;
use Support\Traits\Upload;
use Throwable;

class AdminViewModel
{
    use Makeable;
    use Upload;


    public function Admin($request): Model|null
    {
        return Admin::query()
            ->where('email', $request->email)
            ->where('password', trim($request->password))
            ->first();
    }

    public function a($email): Model|null
    {
        return Admin::query()
            ->where('email', $email)
            ->first();
    }



    public function adminUserList(string $search = '', array $roles = []): LengthAwarePaginator
    {
        $q = User::query()
            ->with(['UserHuman', 'UserLecturer', 'UserCity', 'UserExpert', 'UserSex', 'UserProduction', 'UserSpecialist', 'UserLanguage', 'Tarif', 'Manager'])
            ->withCount([
                'contracts',
                'contracts as contracts_signed_count'   => fn($q) => $q->where('is_signed', true),
                'contracts as contracts_unsigned_count' => fn($q) => $q->where('is_signed', false),
            ]);

        if ($search) {
            $q->where(function ($query) use ($search) {
                $query->where('username', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if (in_array('specialist', $roles)) {
            $q->whereHas('UserSpecialist');
        }
        if (in_array('lecturer', $roles)) {
            $q->whereHas('UserLecturer');
        }
        if (in_array('expert', $roles)) {
            $q->whereHas('UserExpert');
        }

        return $q->orderByDesc(function ($query) {
                $query->selectRaw('COUNT(*)')
                    ->from('cabinet_messages')
                    ->join('cabinet_conversations', 'cabinet_messages.cabinet_conversation_id', '=', 'cabinet_conversations.id')
                    ->whereColumn('cabinet_conversations.user_id', 'users.id')
                    ->where('cabinet_messages.sender_type', User::class)
                    ->whereNull('cabinet_messages.read_at');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(config('site.constants.paginate'));
    }

    public function adminUserId(int $id): ?User
    {
        return User::query()
            ->with(['UserSpecialist', 'UserLecturer', 'UserExpert'])
            ->find($id);
    }

    public function updatePersonalDataAdmin($request, $id): bool
    {

        $data = AdminUpdateDto::formRequest($request);

        $rop = Admin::query()->where('id', $id)->first();

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


}
