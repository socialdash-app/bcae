<?php

namespace App\Console\Commands\ProminentEvents;

use App\Models\ProminentEvents\ElectionIncident;
use Illuminate\Console\Command;
use Zlt\LaravelGoogleSheet\Services\GoogleSheetService;

class ElectionIncidents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prominent-events:election-incidents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new GoogleSheetService;
//        $this->importFactCheckedArticles();
        $data = $service->getValuesBySheetName('1QonRLog0g0b4NRNpka1Utne5l6Mbz-nCwtK9y7SDWeI', 'FirstOne');
        $progress = $this->output->createProgressBar(count($data));
        foreach ($data as $index => $datum) {
            if ($index > 1) {
                ElectionIncident::firstOrCreate([
                    'description_mm' => $datum[0],
                    'description_en' => $datum[1],
                    'topic' => $datum[2],
                    'url' => $datum[3],
                ]);
            }
            $progress->advance();
        }
        $progress->finish();
    }
}
