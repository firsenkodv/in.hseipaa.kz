<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();

            $table->integer('script_published')->default(0);
            $table->text('script')->nullable();
            $table->text('short_desc')->nullable();
            $table->text('show')->nullable();

            $table->string('img')->nullable();
            $table->string('img2')->nullable();
            $table->text('desc')->nullable();
            $table->text('desc2')->nullable();
            $table->integer('published')->default(1);
            $table->text('params')->nullable();
            $table->integer('sorting')->default(999);
            $table->text('metatitle')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_categories');
    }
};
