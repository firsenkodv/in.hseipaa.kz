<?php


namespace App\Console\Commands;
use App\Models\Page;
use Domain\Institute\ViewModels\InstituteViewModel;
use Domain\Service\ViewModels\ServiceViewModel;
use Domain\Timetable\ViewModels\TimetableViewModel;
use Domain\Training\ViewModels\TrainingViewModel;
use Domain\User\ViewModels\UserSpecialistViewModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SitemapCron extends Command
{
    /**
     *
     *
     * @var string
     */
    protected $signature = 'sitemap:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start cron - sitemap:cron';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '8192M');

        if(!Storage::disk('sitemap')->exists('sitemap')) {
            Storage::disk('sitemap')->makeDirectory('sitemap');
            /**
             * создадим если нет директории sitemap
             */

        } else {
            Storage::disk('sitemap')->deleteDirectory('sitemap');
            Storage::disk('sitemap')->makeDirectory('sitemap');
            /**
             * удалим и создадим заново директории sitemap
             */

        }

        $schemas_open = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $url_open = '<url>';
        $loc = '<loc>{s}</loc>';
        $lastmod = '<lastmod>{s}</lastmod>';
        $changefreq = '<changefreq>monthly</changefreq>';
        $priority = '<priority>1.0</priority>';
        $url_close = '</url>';
        $schemas_close = '</urlset>';



        $data  = $schemas_open;
        /** главная   */
                $url = asset(route('home'));

                $data .= $url_open;
                $data .= str_replace("{s}", $url, $loc);
                $data .= str_replace("{s}", date("Y-m-d"), $lastmod);
                $data .= $changefreq;
                $data .= $priority;
                $data .= $url_close;
        /** главная   */
        /** контакты   */
                $url = asset(route('contacts'));

                $data .= $url_open;
                $data .= str_replace("{s}", $url, $loc);
                $data .= str_replace("{s}", date("Y-m-d"), $lastmod);
                $data .= $changefreq;
                $data .= $priority;
                $data .= $url_close;
        /** контакты   */
        /** институты */
        $items = InstituteViewModel::make()->institutes();


        $url = asset(route('institutes'));

        $data .= $url_open;
        $data .= str_replace("{s}", $url, $loc);
        $data .= str_replace("{s}", date("Y-m-d"), $lastmod);
        $data .= $changefreq;
        $data .= $priority;
        $data .= $url_close;



        foreach ($items as $k => $item) {



            $url = asset(route('institute', ['slug' => $item->slug]));
            $data .= $url_open;
            $data .= str_replace("{s}", $url, $loc);
            $data .= str_replace("{s}", $item->updated_at->toAtomString(), $lastmod);
            $data .= $changefreq;
            $data .= $priority;
            $data .= $url_close;

            if(count($item->program))


            {
                foreach ($item->program as $it) {

                    $url = asset(route('program', ['institute_slug' => $item->slug, 'slug' => $it->slug]));

                    $data .= $url_open;
                    $data .= str_replace("{s}", $url, $loc);
                    $data .= str_replace("{s}", $item->updated_at->toAtomString(), $lastmod);
                    $data .= $changefreq;
                    $data .= $priority;
                    $data .= $url_close;
                }
            }

            if(count($item->program_acredit))            {
                foreach ($item->program_acredit as $it) {

                    $url = asset(route('accreditation', ['institute_slug' => $item->slug, 'slug' => $it->slug]));

                    $data .= $url_open;
                    $data .= str_replace("{s}", $url, $loc);
                    $data .= str_replace("{s}", $item->updated_at->toAtomString(), $lastmod);
                    $data .= $changefreq;
                    $data .= $priority;
                    $data .= $url_close;
                }
            }



            }
        /** институты */
        /** обучение  */
        $items = TrainingViewModel::make()->training_categories();

        $url = asset(route('training_categories'));

        $data .= $url_open;
        $data .= str_replace("{s}", $url, $loc);
        $data .= str_replace("{s}",  date("Y-m-d"), $lastmod);
        $data .= $changefreq;
        $data .= $priority;
        $data .= $url_close;
        foreach ($items as $k => $item) {

            $url = asset(route('trainings', ['slug' => $item->slug]));

            $data .= $url_open;
            $data .= str_replace("{s}", $url, $loc);
            $data .= str_replace("{s}", $item->updated_at->toAtomString(), $lastmod);
            $data .= $changefreq;
            $data .= $priority;
            $data .= $url_close;


            if(count($item->training))            {
                foreach ($item->training as $it) {


                    $url = asset(route('training', ['slug' => $item->slug, 'training' => $it->slug]));
                    $data .= $url_open;
                    $data .= str_replace("{s}", $url, $loc);
                    $data .= str_replace("{s}", $item->updated_at->toAtomString(), $lastmod);
                    $data .= $changefreq;
                    $data .= $priority;
                    $data .= $url_close;
                }
            }
        }
        /** обучение  */
        /** сервис  */
        $items = ServiceViewModel::make()->services();

        $url = asset(route('services'));
        $data .= $url_open;
        $data .= str_replace("{s}", $url, $loc);
        $data .= str_replace("{s}", date("Y-m-d"), $lastmod);
        $data .= $changefreq;
        $data .= $priority;
        $data .= $url_close;

        foreach ($items as $k => $item) {

            $url = asset(route('service', ['slug' => $item->slug]));

            $data .= $url_open;
            $data .= str_replace("{s}", $url, $loc);
            $data .= str_replace("{s}", $item->updated_at->toAtomString(), $lastmod);
            $data .= $changefreq;
            $data .= $priority;
            $data .= $url_close;

        }
        /** сервис  */
        /** расписание  */

        $timetable_cities = TimetableViewModel::make()->timetable_cities();

        foreach ($timetable_cities as $item) {




           if(count($item->timetable_lesson))            {
               foreach ($item->timetable_lesson as $it) {

                   $url = asset(route('timetable_city_lesson', ['slug' => $item->slug, 'lesson' => $it->slug]));

                   $data .= $url_open;
                   $data .= str_replace("{s}", $url, $loc);
                   $data .= str_replace("{s}", $item->updated_at->toAtomString(), $lastmod);
                   $data .= $changefreq;
                   $data .= $priority;
                   $data .= $url_close;
               }
           }



           $url = asset(route('timetable_city', ['slug' => $item->slug]));

           $data .= $url_open;
           $data .= str_replace("{s}", $url, $loc);
           $data .= str_replace("{s}", $item->updated_at->toAtomString(), $lastmod);
           $data .= $changefreq;
           $data .= $priority;
           $data .= $url_close;

       }


        /** риестер медиаторов  */
        /** страницы   */

        $pages = Page::query()->where('published', 1)->get();

        foreach ($pages as $item) {

            $url = asset(route('page', ['page' => $item->slug]));

            $data .= $url_open;
            $data .= str_replace("{s}", $url, $loc);
            $data .= str_replace("{s}", $item->updated_at->toAtomString(), $lastmod);
            $data .= $changefreq;
            $data .= $priority;
            $data .= $url_close;

        }
        /** страницы   */

            $data .= $schemas_close;

            //file_put_contents(Storage::disk('sitemap')->path('sitemap').'/sitemap.xml', "$data");
            file_put_contents(Storage::disk('sitemap')->path('sitemap.xml'), "$data");

            sleep(5);

/*            dump('Cознан sitemap - ' . env('APP_URL').'/storage/sitemap/sitemap.xml'); // в консоль
            Log::info('Cознан sitemap - ' . env('APP_URL').'/storage/sitemap/sitemap.xml'); // в логи
            $mailbody[] = 'Cознан sitemap - ' . env('APP_URL').'/storage/sitemap/sitemap.xml'; // в письмо*/




    }


}
