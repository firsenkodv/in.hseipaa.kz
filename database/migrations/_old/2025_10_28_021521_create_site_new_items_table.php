<?php

use App\Models\SiteNew;
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
        Schema::create('site_new_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();

            $table->integer('script_published')->default(0);
            $table->text('script')->nullable();
            $table->text('short_desc')->nullable();
            $table->integer('show')->default(0);

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
            $table->foreignIdFor(SiteNew::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_new_items');
    }
};
