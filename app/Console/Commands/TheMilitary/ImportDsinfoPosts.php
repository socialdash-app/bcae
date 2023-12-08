<?php

namespace App\Console\Commands\TheMilitary;

use App\Models\TheMilitary\DsInfoPost;
use Illuminate\Console\Command;
use Zlt\LaravelGoogleDoc\Services\GoogleDocService;
use Zlt\LaravelGoogleSheet\Services\GoogleSheetService;

class ImportDsinfoPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'the-military:dsinfo-posts';

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
        $data = $service->getValuesBySheetName('1o02j-ktmIjJeZ5KZ2he_Zrg32uwP9DNP4MASNL4Cb6o', 'BCAE');
        $this->info('Starting to import dsinfo');
        $progress = $this->output->createProgressBar(count($data));
        foreach ($data as $key => $row) {
            $progress->advance();
            if ($key > 0) {
                DsInfoPost::firstOrCreate([
                    'date' => $row[2],
                    'platformId' => $row[1],
                    'updated' => $row[3],
                    'message' => $row[4],
                    'type' => $row[6],
                    'series' => $row[7],
                    'isImportant' => $row[5] !== 'NA',
                    'imageText' => $row[8],
                ]);
            }
        }
        $progress->finish();
        $this->newLine();
        $this->info('Starting to import statements');
        $googleDoc = new GoogleDocService();
        $doc = $googleDoc->get('1-T5k9sqUUtQ5NbQFrCXrDL901hSvy2LwBLHWcX71wM4');
        $this->processDocTextValue($doc);
        $this->warn('Finishing Importing DSInfo');
    }

    public function processDocTextValue(string $text)
    {
        $splitCloseBrackets = explode('}', $text);
        foreach ($splitCloseBrackets as $splitCloseBracket) {
            $splitOpenBrackets = preg_split('/\{/', $splitCloseBracket);
            if (!array_key_exists(1, $splitOpenBrackets)) {
                continue;
            }
            $statement = DSInfoPost::firstWhere('date', preg_replace('/\\n/', '', $splitOpenBrackets[0]));
            $statement->detail = preg_replace('/\\n/', '<br>', $splitOpenBrackets[1]);;
            $statement->save();
        }
    }
}
