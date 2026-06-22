<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('questions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('for_all')->default(true);
            $table->json('city_ids')->nullable();
            $table->boolean('has_tariff')->default(false);
            $table->string('person_type')->nullable();
            $table->boolean('is_specialist')->default(false);
            $table->boolean('is_expert')->default(false);
            $table->boolean('is_lecturer')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('polls');
    }
};
