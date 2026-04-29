<?php

namespace App\Http\Controllers;

use Domain\Manager\ViewModels\ManagerViewModel;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function test()
    {
        $users = DB::table('pc0ec_users')->get();

        return view('test', [
            'users' => $users,
        ]);
    }

    public function mediatorreg()
    {
        $rows = DB::table('pc0ec_mediatorreg_reg')->get();

        return view('test_mediatorreg', [
            'rows' => $rows,
        ]);
    }

    /**
     * Единократное обновление таблицы users данными из pc0ec_mediatorreg_reg.
     * Связь: pc0ec_mediatorreg_reg.user_id = users.joomla_id
     */
    public function updateFromMediatorreg()
    {

       // dd('stop');
        // Предзагружаем справочники, чтобы не делать N+1 запросов
        $cities    = DB::table('user_cities')->pluck('id', 'title');    // ['Алматы' => 1, ...]
        $sexes     = DB::table('user_sexes')->pluck('id', 'title');     // ['Мужчина' => 1, ...]
        $languages = DB::table('user_languages')->pluck('id', 'title'); // ['Русский' => 1, ...]

        $updated  = 0;
        $notFound = 0;
        $now      = now();

        DB::table('pc0ec_mediatorreg_reg')->orderBy('id')->chunk(100, function ($rows) use (
            $cities, $sexes, $languages, $now, &$updated, &$notFound
        ) {
            foreach ($rows as $row) {
                // Ищем пользователя в users по joomla_id
                $user = DB::table('users')->where('joomla_id', $row->user_id)->first();

                if (!$user) {
                    $notFound++;
                    continue;
                }

                // --- Телефон: только цифры, ведущая 8 → 7 ---
                $phone = preg_replace('/\D/', '', $row->phone ?? '');
                if (str_starts_with($phone, '8')) {
                    $phone = '7' . substr($phone, 1);
                }

                // --- Дата рождения: "16. 04. 2022" → "2022-04-16" ---
                $birthday = null;
                if (!empty($row->datepicker)) {
                    try {
                        $birthday = \Carbon\Carbon::createFromFormat('d. m. Y', $row->datepicker)->format('Y-m-d');
                    } catch (\Exception) {
                        $birthday = null;
                    }
                }

                // --- Город ---
                $cityId = $cities->get($row->sity);

                // --- Пол ---
                $sexId = $sexes->get($row->sex);

                // --- Адрес (JSON) ---
                $address = json_encode([
                    'street' => $row->street  ?? null,
                    'home'   => $row->home    ?? null,
                    'office' => $row->office  ?? null,
                ]);

                // --- Пароль: plain text → bcrypt ---
                $password = !empty($row->password) ? \Illuminate\Support\Facades\Hash::make($row->password) : $user->password;

                // Обновляем запись в users
                DB::table('users')->where('id', $user->id)->update([
                    'username'      => $row->username  ?: $user->username,
                    'company'       => $row->company   ?: null,
                    'password'      => $password,
                    'user_city_id'  => $cityId         ?: null,
                    'address'       => $address,
                    'user_sex_id'   => $sexId          ?: null,
                    'date_birthday' => $birthday,
                    'phone'         => $phone          ?: null,
                    'iin'           => $row->inn        ?: null,
                    'bin'           => $row->bin        ?: null,
                    'updated_at'    => $now,
                ]);

                // --- Языки: "Русский,Казахский,Английский" → pivot ---
                if (!empty($row->language)) {
                    $langNames = array_map('trim', explode(',', $row->language));
                    $langIds   = collect($langNames)
                        ->map(fn($name) => $languages->get($name))
                        ->filter()
                        ->values();

                    // Удаляем старые записи и вставляем новые
                    DB::table('user_user_language')->where('user_id', $user->id)->delete();

                    $pivotRows = $langIds->map(fn($langId) => [
                        'user_id'          => $user->id,
                        'user_language_id' => $langId,
                        'created_at'       => $now,
                        'updated_at'       => $now,
                    ])->all();

                    if ($pivotRows) {
                        DB::table('user_user_language')->insert($pivotRows);
                    }
                }

                $updated++;
            }
        });

        return response()->json([
            'updated'   => $updated,
            'not_found' => $notFound,
            'message'   => "Готово. Обновлено: {$updated}, не найдено в users: {$notFound}",
        ]);
    }

    /**
     * Единократное копирование пользователей из Joomla (pc0ec_users) в таблицу users.
     * Пароли сохраняются как есть (MD5 или bcrypt) — без повторного хэширования.
     * Пользователи с уже существующим email пропускаются.
     */
    public function copyJoomlaUsers()
    {

      //  dd('stop');
        $defaultManagerId = ManagerViewModel::make()->mainManager()?->id;
        $now = now();
        $inserted = 0;
        $skipped  = 0;

        DB::table('pc0ec_users')->orderBy('id')->chunk(100, function ($joomlaUsers) use ($defaultManagerId, $now, &$inserted, &$skipped) {
            foreach ($joomlaUsers as $joomla) {
                $exists = DB::table('users')->where('email', $joomla->email)->exists();

                if ($exists) {
                    $skipped++;
                    continue;
                }

                DB::table('users')->insert([
                    'joomla_id'  => $joomla->id,
                    'username'   => $joomla->username ?? $joomla->name,
                    'email'      => $joomla->email,
                    'password'   => $joomla->password, // сохраняем как есть, минуя cast 'hashed'
                    'published'  => $joomla->block ? 0 : 1,
                    'manager_id' => $defaultManagerId,
                    'created_at' => ($joomla->registerDate && $joomla->registerDate !== '0000-00-00 00:00:00') ? $joomla->registerDate : $now,
                    'updated_at' => $now,
                ]);

                $inserted++;
            }
        });

        return response()->json([
            'inserted' => $inserted,
            'skipped'  => $skipped,
            'message'  => "Готово. Скопировано: {$inserted}, пропущено (уже есть в users): {$skipped}",
        ]);
    }
}
