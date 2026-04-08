<?php

namespace App\Http\Controllers\Cabinet\Message;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Models\ROP;
use Domain\CabinetMessage\DTOs\CabinetMessageDto;
use Domain\CabinetMessage\ViewModels\CabinetMessageViewModel;
use Domain\Manager\ViewModels\ManagerViewModel;
use Domain\ROP\ViewModels\ROPViewModel;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Http\Request;

class ToUser extends Controller
{
    public function toUser(Request $request)
    {

        $action = $request->action;
        if ($action === 'published') {
            UserViewModel::make()->userSetPublished($request->user_id);
            flash()->info(config('message_flash.info.user_published'));
        } elseif ($action === 'blocked') {
            UserViewModel::make()->userSetBlocked($request->user_id);
            flash()->alert(config('message_flash.alert.user_blocked'));
        }

        if (in_array($action, ['published', 'blocked', 'message'])) {
            $role = session('active_role', '');
            [$staff, $staffClass] = $this->resolveStaff($role);

            //dump($staffClass, $staff->username);

            if ($staff && $request->filled('body')) {

                $dto = new CabinetMessageDto(
                    user_id:     (int) $request->user_id,
                    body:        $request->body,
                    staff_type:  $staffClass,
                    staff_id:    $staff->id,
                    sender_type: $staffClass,
                    sender_id:   $staff->id,
                );
                CabinetMessageViewModel::make()->send($dto);
                if ($action === 'message') {
                    flash()->info(config('message_flash.info.cabinet_message_send_ok'));
                }
            }
        }

        return redirect()->back();
    }

    public function cabinetMessageDelete(Request $request)
    {
        $role = session('active_role', '');
        [$staff, $staffClass] = $this->resolveStaff($role);

        if (!$staff || !$request->filled('message_id')) {
            return response()->json(['success' => false], 403);
        }

        try {
            CabinetMessageViewModel::make()->delete(
                (int) $request->message_id,
                $staffClass,
                $staff->id,
            );
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false], 404);
        }
    }

    private function resolveStaff(string $role = ''): array
    {

        if ($role === 'manager') {
            if ($email = session()->get('m')) {
                $staff = ManagerViewModel::make()->m($email);
                if ($staff) return [$staff, Manager::class];
            }
        } elseif ($role === 'rop') {
            if ($email = session()->get('r')) {
                $staff = ROPViewModel::make()->r($email);
                if ($staff) return [$staff, ROP::class];
            }
        } else {
            if ($email = session()->get('m')) {
                $staff = ManagerViewModel::make()->m($email);
                if ($staff) return [$staff, Manager::class];
            }
            if ($email = session()->get('r')) {
                $staff = ROPViewModel::make()->r($email);
                if ($staff) return [$staff, ROP::class];
            }
        }

        return [null, null];
    }

}
