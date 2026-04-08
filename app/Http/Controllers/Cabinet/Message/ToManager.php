<?php

namespace App\Http\Controllers\Cabinet\Message;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Models\User;
use Domain\CabinetMessage\DTOs\CabinetMessageDto;
use Domain\CabinetMessage\ViewModels\CabinetMessageViewModel;
use Illuminate\Http\Request;

class ToManager extends Controller
{
    public function toManager(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user && $user->manager_id && $request->filled('body')) {
            $dto = new CabinetMessageDto(
                user_id:     $user->id,
                body:        $request->body,
                staff_type:  Manager::class,
                staff_id:    $user->manager_id,
                sender_type: User::class,
                sender_id:   $user->id,
            );
            CabinetMessageViewModel::make()->send($dto);
            flash()->info(config('message_flash.info.cabinet_message_send_ok'));
        }

        return redirect()->back();
    }

    public function cabinetMessageDelete(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        if (!$user || !$request->filled('message_id')) {
            return response()->json(['success' => false], 403);
        }

        try {
            CabinetMessageViewModel::make()->delete(
                (int) $request->message_id,
                User::class,
                $user->id,
            );
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false], 404);
        }
    }

}
