<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poll_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_response_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('question_index');
            $table->text('question_text');
            $table->text('answer');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poll_answers');
    }
};
