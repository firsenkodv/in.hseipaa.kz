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
        Schema::create('mzps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('slug')->unique();
            $table->integer('published')->default(1);
            $table->text('text')->nullable();
            $table->text('desc')->nullable();
            $table->string('menu')->nullable();
            $table->string('y')->unique();
            $table->text('td_1')->nullable();
            $table->text('td_2')->nullable();
            $table->text('td_3')->nullable();
            $table->text('td_4')->nullable();
            $table->text('td_5')->nullable();
            $table->integer('presently')->default(1);

            $table->text('params')->nullable();
            $table->integer('sorting')->default(999);
            $table->text('metatitle')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->string('faq_title')->nullable();
            $table->text('faq')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mzps');
    }
};
