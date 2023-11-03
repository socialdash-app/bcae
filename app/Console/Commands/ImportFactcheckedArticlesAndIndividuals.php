<?php

namespace App\Console\Commands;

use App\Models\CorrelatedActions\Disinformation\FactCheckedArticle;
use App\Models\CorrelatedActions\Disinformation\FactCheckedContent;
use App\Models\CorrelatedActions\Disinformation\Propagandist;
use Carbon\Carbon;
use Google\Service\Sheets;
use Illuminate\Console\Command;
use Zlt\LaravelGoogleSheet\Services\GoogleSheetService;

class ImportFactcheckedArticlesAndIndividuals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-factchecked';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected GoogleSheetService $service;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->service = new GoogleSheetService;
//        $this->importFactCheckedArticles();
        $this->importFactcheckedContents();
    }

    public function importFactCheckedArticles(): void
    {
        $this->info('Importing fact checked articles');
        $values = $this->service->getValuesBySheetName('1D2CT0O_xSq6c_0RyYRMVLLlSKQv9FbUObARG9pBfVvs', 'Factchecked');
        unset($values[0]);
        $untilDate = new Carbon('2021-02-01');
        $progress = $this->output->createProgressBar(count($values));
        foreach ($values as $value) {
            $progress->advance();
            if ((new Carbon($value[1]))->greaterThanOrEqualTo($untilDate)) {
                continue;
            }
            FactCheckedArticle::firstOrCreate([
                'id' => $value[4],
            ], [
                'fact_checker' => $value[0],
                'date' => $value[1],
                'title' => $value[2],
                'url' => $value[3],
                'platform' => $value[5],
                'topic' => $value[6]
            ]);
        }
        $progress->finish();
        $this->newLine();
    }

    public function importFactcheckedContents(): void
    {
        $this->info('Importing fact checked contents');
        $values = $this->service->getValuesBySheetName('1D2CT0O_xSq6c_0RyYRMVLLlSKQv9FbUObARG9pBfVvs', 'content');
        unset($values[0]);
        $progress = $this->output->createProgressBar(count($values));
        $factCheckedIds = FactCheckedArticle::pluck('id')->toArray();
        foreach ($values as $value) {
            $progress->advance();
            if (!in_array($value[0], $factCheckedIds)) {
                continue;
            }
            FactCheckedContent::firstOrCreate([
                'fact_checked_article_id' => $value[0],
                'url' => $value[1],
                'type' => $value[2],
                'username' => $value[3] === 'NA' ? null : $value[3],
                'id' => $value[4] === 'NA' ? null : $value[4],
                'platform' => $value[7],
            ]);
        }
        $progress->finish();
        $this->newLine();
    }
}
