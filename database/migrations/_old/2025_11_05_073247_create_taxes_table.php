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
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('slug')->unique();
            $table->integer('published')->default(1);
            $table->text('jan')->nullable();
            $table->text('feb')->nullable();
            $table->text('mar')->nullable();
            $table->text('apr')->nullable();
            $table->text('mai')->nullable();
            $table->text('jun')->nullable();
            $table->text('jul')->nullable();
            $table->text('aug')->nullable();
            $table->text('sept')->nullable();
            $table->text('oct')->nullable();
            $table->text('nov')->nullable();
            $table->text('dec')->nullable();
            $table->text('text')->nullable();

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
        Schema::dropIfExists('taxes');
    }
};
