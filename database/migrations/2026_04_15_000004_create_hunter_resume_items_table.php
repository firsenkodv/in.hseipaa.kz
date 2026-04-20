<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hunter_resume_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->string('img')->nullable();
            $table->integer('published')->default(0);
            $table->integer('sorting')->default(999);

            $table->foreignId('hunter_category_id')
                ->nullable()
                ->constrained('hunter_categories')
                ->nullOnDelete();

            $table->foreignId('user_city_id')
                ->nullable()
                ->constrained('user_cities')
                ->nullOnDelete();

            $table->foreignId('hunter_experience_id')
                ->nullable()
                ->constrained('hunter_experiences')
                ->nullOnDelete();

            $table->integer('price')->nullable();
            $table->string('logo')->nullable();
            $table->string('company')->nullable();
            $table->text('desc')->nullable();
            $table->text('must')->nullable();
            $table->text('conditions')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->bigInteger('phone')->nullable();
            $table->string('telegram')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('params')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hunter_resume_items');
    }
};
