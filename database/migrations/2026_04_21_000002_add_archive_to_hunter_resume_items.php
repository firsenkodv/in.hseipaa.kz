<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hunter_resume_items', function (Blueprint $table) {
            $table->date('expired_at')->nullable()->after('published');
            $table->enum('archive', ['ARCHIVE', 'NOTARCHIVED'])->default('NOTARCHIVED')->after('expired_at');
        });
    }

    public function down(): void
    {
        Schema::table('hunter_resume_items', function (Blueprint $table) {
            $table->dropColumn(['expired_at', 'archive']);
        });
    }
};
