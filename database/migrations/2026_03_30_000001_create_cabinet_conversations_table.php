<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cabinet_conversations', function (Blueprint $table) {
            $table->id();

            // Пользователь — одна сторона переписки
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Сотрудник (ROP или Manager) — полиморфная связь
            $table->morphs('staff'); // staff_type, staff_id

            $table->timestamps();

            // Одна активная переписка между конкретным user и конкретным staff
            $table->unique(['user_id', 'staff_type', 'staff_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cabinet_conversations');
    }
};
