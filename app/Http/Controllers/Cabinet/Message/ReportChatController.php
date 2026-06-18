<?php

namespace App\Http\Controllers\Cabinet\Message;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Models\Report;
use App\Models\User;
use Domain\CabinetMessage\DTOs\CabinetMessageDto;
use Domain\CabinetMessage\ViewModels\CabinetMessageViewModel;
use Domain\Manager\ViewModels\ManagerViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportChatController extends Controller
{
    /** Менеджер отправляет сообщение по отчёту */
    public function managerSend(Request $request): JsonResponse
    {
        $request->validate([
            'report_id' => 'required|integer',
            'user_id'   => 'required|integer',
            'body'      => 'required|string|max:5000',
        ]);

        $email = session('m');
        if (!$email) abort(403);

        $manager = ManagerViewModel::make()->m($email);
        if (!$manager) abort(403);

        Report::where('id', $request->integer('report_id'))
            ->whereHas('user', fn($q) => $q->where('manager_id', $manager->id))
            ->firstOrFail();

        $dto = new CabinetMessageDto(
            user_id:     $request->integer('user_id'),
            body:        $request->input('body'),
            staff_type:  Manager::class,
            staff_id:    $manager->id,
            sender_type: Manager::class,
            sender_id:   $manager->id,
            report_id:   $request->integer('report_id'),
        );

        $message = CabinetMessageViewModel::make()->send($dto);
        $message->load('sender');

        return response()->json([
            'success' => true,
            'html'    => view('components.report-chat.message', [
                'msg'        => $message,
                'senderRole' => 'staff',
            ])->render(),
        ]);
    }

    /** Пользователь отправляет ответ по отчёту */
    public function userSend(Request $request): JsonResponse
    {
        $request->validate([
            'report_id' => 'required|integer',
            'body'      => 'required|string|max:5000',
        ]);

        $user = auth()->user();

        Report::where('id', $request->integer('report_id'))
            ->where('user_id', $user->id)
            ->firstOrFail();

        if (!$user->manager_id) {
            return response()->json(['success' => false, 'error' => 'Менеджер не назначен'], 403);
        }

        $dto = new CabinetMessageDto(
            user_id:     $user->id,
            body:        $request->input('body'),
            staff_type:  Manager::class,
            staff_id:    $user->manager_id,
            sender_type: User::class,
            sender_id:   $user->id,
            report_id:   $request->integer('report_id'),
        );

        $message = CabinetMessageViewModel::make()->send($dto);
        $message->load('sender');

        return response()->json([
            'success' => true,
            'html'    => view('components.report-chat.message', [
                'msg'        => $message,
                'senderRole' => 'user',
            ])->render(),
        ]);
    }
}
