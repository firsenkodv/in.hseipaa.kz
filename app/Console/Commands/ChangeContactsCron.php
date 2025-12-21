<?php

namespace App\Console\Commands;

use App\Mail\Test\TestMail;
use App\Models\ChangeLoadContact;
use App\Models\ChangeSaveContact;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Support\Traits\EmailAddressCollector;

class ChangeContactsCron extends Command
{
    use EmailAddressCollector;


    /**
     * Тестовый запуск php artisan schedule:run
     *
     * @var string
     */
    protected $signature = 'change-contacts:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start cron - change-contacts:cron';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '8192M');

        $p = 0;
        $w = 0;
        $t = 0;
        $from = ChangeLoadContact::query()->first();
        $to = ChangeSaveContact::query()->first();
        $next = 0;
        if ($from->phone_mode == 2) {

            foreach ($to->phone as $k => $phone) {

                if ($phone['p'] == $from->phone) {
                    $i  = count($to->phone);
                    if($k == $i) {
                        $next = 1;
                    } else {
                        $next = $k + 1;
                    }
                }

            }
            if ($next) {
                $from->phone = $to->phone[$next]['p'];
                $from->save();
                // Log::info($to->phone[$next]['p']); // в логи
                $p = 'phone сменили';

            }

        }
        $next = 0;
        if ($from->whatsapp_mode == 2) {
            foreach ($to->whatsapp as $k => $whatsapp) {

                if ($whatsapp['p'] == $from->whatsapp) {
                    $i  = count($to->whatsapp);
                    if($k == $i) {
                        $next = 1;
                    } else {
                        $next = $k + 1;
                    }
                }

            }
            if ($next) {
                $from->whatsapp = $to->whatsapp[$next]['p'];
                $from->save();
                // Log::info($to->phone[$next]['p']); // в логи
                $w = 'whatsapp сменили';

            }

        }
        $next = 0;
        if ($from->telegram_mode == 2) {

            foreach ($to->telegram as $k => $telegram) {

                if ($telegram['p'] == $from->telegram) {
                    $i  = count($to->telegram);
                    if($k == $i) {
                        $next = 1;
                    } else {
                        $next = $k + 1;
                    }
                }

            }
            if ($next) {
                $from->telegram = $to->telegram[$next]['p'];
                $from->save();
                $t = 'telegram сменили';
                // Log::info($to->phone[$next]['p']); // в логи
            }

        }
        /** @var  $data  ..только для тестов */
        $data = array();

        if($p) {
            $data['phone'] = $p;
        }

        if($w) {
            $data['whatsapp'] = $w;
        }

        if($t) {
            $data['telegram'] = $t;
        }

        Mail::to($this->emails())->send(new TestMail($data));

        /** потом закоментируй  ..только для тестов */

    }



}
