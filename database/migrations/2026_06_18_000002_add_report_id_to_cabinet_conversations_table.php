<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cabinet_conversations', function (Blueprint $table) {
            if (!Schema::hasColumn('cabinet_conversations', 'report_id')) {
                $table->unsignedBigInteger('report_id')->default(0)->after('staff_id');
            }
        });

        $dbName = DB::getDatabaseName();

        // Drop FK if it still exists
        $fk = DB::select("
            SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'cabinet_conversations'
              AND CONSTRAINT_NAME = 'cabinet_conversations_user_id_foreign'
              AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        ", [$dbName]);
        if ($fk) {
            DB::statement('ALTER TABLE cabinet_conversations DROP FOREIGN KEY cabinet_conversations_user_id_foreign');
        }

        // Drop old unique if it still exists
        $oldUniq = DB::select("
            SELECT INDEX_NAME FROM information_schema.STATISTICS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'cabinet_conversations'
              AND INDEX_NAME = 'cabinet_conversations_user_id_staff_type_staff_id_unique'
        ", [$dbName]);
        if ($oldUniq) {
            DB::statement('ALTER TABLE cabinet_conversations DROP INDEX cabinet_conversations_user_id_staff_type_staff_id_unique');
        }

        // Add new unique if not yet added
        $newUniq = DB::select("
            SELECT INDEX_NAME FROM information_schema.STATISTICS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'cabinet_conversations'
              AND INDEX_NAME = 'conv_user_staff_report_unique'
        ", [$dbName]);
        if (!$newUniq) {
            DB::statement('ALTER TABLE cabinet_conversations ADD UNIQUE KEY conv_user_staff_report_unique (user_id, staff_type, staff_id, report_id)');
        }

        // Re-add FK if not yet added
        $newFk = DB::select("
            SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'cabinet_conversations'
              AND CONSTRAINT_NAME = 'cabinet_conversations_user_id_foreign'
              AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        ", [$dbName]);
        if (!$newFk) {
            DB::statement('ALTER TABLE cabinet_conversations ADD CONSTRAINT cabinet_conversations_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        }
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE cabinet_conversations DROP FOREIGN KEY cabinet_conversations_user_id_foreign');
        DB::statement('ALTER TABLE cabinet_conversations DROP INDEX conv_user_staff_report_unique');
        Schema::table('cabinet_conversations', function (Blueprint $table) {
            $table->dropColumn('report_id');
            $table->unique(['user_id', 'staff_type', 'staff_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
