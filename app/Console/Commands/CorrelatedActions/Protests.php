<?php

namespace App\Console\Commands\CorrelatedActions;

use App\Models\CorrelatedActions\Protest;
use Illuminate\Console\Command;
use Zlt\LaravelGoogleSheet\Services\GoogleSheetService;

class Protests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'correlated-actions:protests';

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
        $this->importProtests();
    }

    public function importProtests()
    {
        $data = $this->service->getValuesBySheetName('1r886v5AW5Z5bLomTMs9fBS3Lg29T2zJpmR1ZEIB06Ug', 'BCAE');
        $progress = $this->output->createProgressBar(count($data));
        $this->warn('Starting to import protest data');
        foreach ($data as $key => $row) {
            $progress->advance();
            if ($key > 0) {
                Protest::firstOrCreate([
                    'date' => $row[0],
                    'place' => $row[1],
                    'lat' => $row[2] ?? 'NA',
                    'lon' => $row[3] ?? 'NA',
                    'township' => $row[4],
                    'stateOrRegion' => $row[5],
                    'numberOfPeople' => $row[6],
                    'approx' => $row[7] === 'TRUE',
                    'affiliation1' => $row[9],
                    'affiliation2' => $row[10] ?? 'NA',
                    'affiliation3' => $row[11] ?? 'NA',
                    'against' => $row[12] ?? 'NA'
                ]);
            }
        }
        $progress->finish();
        $this->newLine();
    }
}
