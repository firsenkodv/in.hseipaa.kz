<?php

namespace Domain\CabinetMessage\ViewModels;

use App\Models\CabinetConversation;
use App\Models\CabinetMessage;
use Domain\CabinetMessage\DTOs\CabinetMessageDto;
use Illuminate\Support\Collection;
use Support\Traits\Makeable;

class CabinetMessageViewModel
{
    use Makeable;

    /**
     * Пометить все сообщения от staff как прочитанные (при открытии страницы сообщений пользователем).
     */
    public function markReadByUser(int $userId): void
    {
        $conversationIds = CabinetConversation::where('user_id', $userId)->pluck('id');

        if ($conversationIds->isEmpty()) {
            return;
        }

        CabinetMessage::whereIn('cabinet_conversation_id', $conversationIds)
            ->where('sender_type', '!=', \App\Models\User::class)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * Пометить все сообщения от пользователя как прочитанные (при открытии переписки staff-ом).
     */
    public function markReadByStaff(int $userId): void
    {
        $conversationIds = CabinetConversation::where('user_id', $userId)->pluck('id');

        if ($conversationIds->isEmpty()) {
            return;
        }

        CabinetMessage::whereIn('cabinet_conversation_id', $conversationIds)
            ->where('sender_type', \App\Models\User::class)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * Количество непрочитанных сообщений для пользователя (отправленных стафом).
     */
    public function unreadCountForUser(int $userId): int
    {
        $conversationIds = CabinetConversation::where('user_id', $userId)->pluck('id');

        if ($conversationIds->isEmpty()) {
            return 0;
        }

        return CabinetMessage::whereIn('cabinet_conversation_id', $conversationIds)
            ->where('sender_type', '!=', \App\Models\User::class)
            ->whereNull('read_at')
            ->count();
    }

    /**
     * Количество непрочитанных сообщений от конкретного пользователя.
     */
    public function unreadCountFromUser(int $userId): int
    {
        $conversationIds = CabinetConversation::where('user_id', $userId)->pluck('id');

        if ($conversationIds->isEmpty()) {
            return 0;
        }

        return CabinetMessage::whereIn('cabinet_conversation_id', $conversationIds)
            ->where('sender_type', \App\Models\User::class)
            ->whereNull('read_at')
            ->count();
    }

    /**
     * Отправить сообщение.
     * Если переписка между staff и user ещё не существует — создаём её.
     */
    public function send(CabinetMessageDto $dto): CabinetMessage
    {
        $conversation = CabinetConversation::firstOrCreate([
            'user_id'    => $dto->user_id,
            'staff_type' => $dto->staff_type,
            'staff_id'   => $dto->staff_id,
        ]);

        return $conversation->messages()->create([
            'sender_type' => $dto->sender_type,
            'sender_id'   => $dto->sender_id,
            'body'        => $dto->body,
        ]);
    }

    /**
     * Удалить своё сообщение (только если sender совпадает со staff)
     */
    public function delete(int $messageId, string $staffType, int $staffId): bool
    {
        $message = CabinetMessage::where('id', $messageId)
            ->where('sender_type', $staffType)
            ->where('sender_id', $staffId)
            ->firstOrFail();

        return $message->delete();
    }

    /**
     * Получить все сообщения пользователя по всем его перепискам (ROP + Manager).
     */
    public function allMessagesForUser(int $userId, string $order = 'asc'): Collection
    {
        $conversationIds = CabinetConversation::where('user_id', $userId)
            ->pluck('id');

        if ($conversationIds->isEmpty()) {
            return collect();
        }

        return CabinetMessage::whereIn('cabinet_conversation_id', $conversationIds)
            ->with('sender')
            ->orderBy('created_at', $order)
            ->get();
    }

    /**
     * Получить все сообщения переписки между конкретным staff и user.
     * Возвращает пустую коллекцию, если переписка ещё не начата.
     */
    public function forConversation(int $userId, string $staffType, int $staffId): Collection
    {
        $conversation = CabinetConversation::where([
            'user_id'    => $userId,
            'staff_type' => $staffType,
            'staff_id'   => $staffId,
        ])->first();

        if (!$conversation) {
            return collect();
        }

        return $conversation->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();
    }
}
