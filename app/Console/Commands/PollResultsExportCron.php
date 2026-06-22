<?php

namespace App\Console\Commands;

use App\Exports\PollResultsExport;
use App\Models\Poll;
use App\Models\PollResponse;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PollResultsExportCron extends Command
{
    /**
     * Запуск: php artisan poll:export-results
     * С флагом --force перегенерирует уже существующие файлы
     *
     * @var string
     */
    protected $signature = 'poll:export-results
                            {--force : Перегенерировать файлы даже если они уже существуют}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start cron - poll:export-results';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '8192M');

        $query = Poll::query()
            ->where('is_active', true)
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', today());

        if (!$this->option('force')) {
            $query->whereNull('results_file');
        }

        $polls = $query->get();

        if ($polls->isEmpty()) {
            $this->info('Нет завершённых опросов для экспорта.');
            return;
        }

        foreach ($polls as $poll) {
            $this->exportPoll($poll);
        }

        $this->info('Готово.');
    }

    /**
     * Формирует и сохраняет Excel-файл для одного опроса.
     */
    private function exportPoll(Poll $poll)
    {
        $responses = PollResponse::where('poll_id', $poll->id)
            ->with(['user', 'answers'])
            ->get();

        if ($responses->isEmpty()) {
            $this->line("  Опрос #{$poll->id} «{$poll->title}» — нет ответов, пропускаем.");
            return;
        }

        $questions = $poll->questions ?? [];

        // Шапка: №, ФИО, Email, Телефон, затем вопросы
        $headings = ['№', 'ФИО', 'Email', 'Телефон'];
        foreach ($questions as $idx => $q) {
            $headings[] = 'Вопрос ' . ($idx + 1) . ': ' . ($q['question'] ?? '');
        }

        // Строки данных
        $rows = [];
        foreach ($responses as $num => $response) {
            $user = $response->user;
            $row  = [
                $num + 1,
                $user->username ?? '',
                $user->email    ?? '',
                $user->phone    ?? '',
            ];

            $answersMap = $response->answers->keyBy('question_index');
            foreach ($questions as $idx => $q) {
                $row[] = $answersMap->get($idx)?->answer ?? '';
            }

            $rows[] = $row;
        }

        $safeTitle = preg_replace('/[^\p{L}\p{N}_\-]/u', '_', $poll->title);
        $safeTitle = trim(preg_replace('/_+/', '_', $safeTitle), '_');
        $filename  = 'poll-results/' . $safeTitle . '.xlsx';

        Storage::disk('public')->makeDirectory('poll-results');

        Excel::store(
            new PollResultsExport($headings, $rows, $poll->title),
            $filename,
            'public'
        );

        $poll->update(['results_file' => $filename]);

        $this->info("  Опрос #{$poll->id} «{$poll->title}» — экспортировано {$responses->count()} ответов → {$filename}");
    }
}
