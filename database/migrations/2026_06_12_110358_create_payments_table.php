<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('amount');              // сумма в тиынах (отправлена в банк)
            $table->unsignedInteger('paid_amount')->nullable(); // фактически оплаченная сумма в тенге
            $table->text('desc')->nullable();
            $table->text('params')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tarif_id')->nullable()->constrained('tarifs')->onDelete('set null');
            $table->string('order_id')->nullable();             // ID заказа от банка
            $table->string('currency')->nullable();             // 398 (KZT)
            $table->tinyInteger('order_status')->nullable();    // статус от банка (2 = успех)
            $table->boolean('is_paid')->default(false);
            $table->string('lang')->nullable();
            $table->text('data')->nullable();                   // полный JSON ответ банка
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
