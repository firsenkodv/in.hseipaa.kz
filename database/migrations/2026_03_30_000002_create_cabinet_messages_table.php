<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cabinet_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cabinet_conversation_id')
                ->constrained('cabinet_conversations')
                ->cascadeOnDelete();

            // Отправитель — полиморфная связь (User, ROP или Manager)
            $table->morphs('sender'); // sender_type, sender_id

            $table->text('body');

            // Когда сообщение прочитано другой стороной
            $table->timestamp('read_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cabinet_messages');
    }
};
