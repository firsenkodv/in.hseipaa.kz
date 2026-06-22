<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('polls', function (Blueprint $table) {
            $table->string('results_file')->nullable()->after('expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('polls', function (Blueprint $table) {
            $table->dropColumn('results_file');
        });
    }
};
