<?php

use App\Models\UserCity;
use App\Models\UserHuman;
use App\Models\UserSex;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->string('username')->nullable()->after('name');
            $table->string('phone')->nullable()->after('email');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignIdFor(UserCity::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(UserHuman::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(UserSex::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('iin')->nullable();
            $table->text('address')->nullable();
            $table->date('date_birthday')->nullable();
            $table->text('certificate')->nullable(); // описание
            $table->text('about_me')->nullable();
            $table->text('experience')->nullable(); // опыт

            $table->string('telegram')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->string('network')->nullable();

            $table->string('accountant_work')->nullable(); // Место работы (наименование организации)
            $table->string('accountant_position')->nullable(); //Должность
            $table->string('accountant_ticket')->nullable(); // Номер сертификата профессионального бухгалтера
            $table->date('accountant_ticket_date')->nullable(); // Дата выдачи сертификата профессионального бухгалтера
            $table->date('date_entry')->nullable(); // Дата выдачи сертификата профессионального бухгалтера
            $table->string('ticket_number')->nullable(); // Номер членского билета или документа, подтверждающего членство в профессиональной организации бухгалтеров
            $table->string('bin')->nullable();
            $table->string('company')->nullable(); //Компания
            $table->string('position_boss')->nullable(); //ФИО первого руководителя
            $table->integer('account_delete')->default(0); // удалим аккаунт
            $table->text('file_id_card')->nullable(); // Удостоверение личности
            $table->text('file_criminal_record')->nullable(); // Справка об отсутствии судимости
            $table->text('file_ dispensary')->nullable(); // Справка с псих. Диспансера
            $table->text('file_ diploma_education')->nullable(); // Диплом о высшем образовании
            $table->text('file_accountant_certificate')->nullable(); // Сертификат бухгалтера
            $table->text('file_scientific_degrees')->nullable(); // Научные степени
            $table->text('file_legal_registration')->nullable(); // Справка о регистрации компании
            $table->text('file_legal_regulation')->nullable(); // Устав
            $table->text('file_legal_first_boss ')->nullable(); // Приказ на первого руководителя

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
