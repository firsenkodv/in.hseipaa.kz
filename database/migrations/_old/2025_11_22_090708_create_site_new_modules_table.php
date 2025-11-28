<?php

use App\Models\SiteNew;
use App\Models\SiteNewItem;
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
        Schema::create('site_new_modules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('img');
            $table->string('link')->nullable();
            $table->text('params')->nullable();
            $table->foreignIdFor(SiteNew::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(SiteNewItem::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->integer('sorting')->default(999);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_new_modules');
    }
};
