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
        Schema::table('user_user_file_qualification', function (Blueprint $table) {
            $table->date('certificate_date')->nullable()->after('custom_documents');
        });
    }

    public function down(): void
    {
        Schema::table('user_user_file_qualification', function (Blueprint $table) {
            $table->dropColumn('certificate_date');
        });
    }
};
