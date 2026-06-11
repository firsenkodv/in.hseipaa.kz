<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('organization_tmp')->nullable()->after('organizations');
        });

        DB::statement("
            UPDATE contracts
            SET organization_tmp = JSON_UNQUOTE(JSON_EXTRACT(organizations, '$[0]'))
            WHERE organizations IS NOT NULL
              AND JSON_VALID(organizations)
              AND JSON_TYPE(organizations) = 'ARRAY'
        ");

        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('organizations');
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->renameColumn('organization_tmp', 'organizations');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->json('organizations')->nullable()->change();
        });
    }
};
