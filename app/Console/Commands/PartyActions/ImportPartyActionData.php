<?php

namespace App\Console\Commands\PartyActions;

use App\Models\PartyActions\Party;
use App\Models\PartyActions\PartyAccusation;
use App\Models\PartyActions\UECAccusation;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Zlt\LaravelGoogleSheet\Services\GoogleSheetService;

class ImportPartyActionData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'party-reactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected GoogleSheetService $service;

    protected Collection $partyNames;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->service = new GoogleSheetService;
        $this->importPartyNames();
        $this->importPartyAccusations();
        $this->importUECAccusations();
    }

    private function importPartyNames(): void
    {
        $this->partyNames = collect([]);
        $data = $this->service->getValuesBySheetName('1x3t6tR_oVjmZ-47Rjwsvxn3q5sKVhYDiwJPf43JxYew', 'EN_MM');
        foreach ($data as $key => $row) {
            if ($key > 0) {
                $party = Party::firstOrCreate([
                    'mm' => $row[0],
                    'en' => $row[1],
                ]);
                $this->partyNames->push($party);
            }
        }
    }

    protected function importPartyAccusations(): void
    {
        $data = $this->service->getValuesBySheetName('1mR8WykAf33cmyhNxX-Y1RG11A1-JdC6RKkqGg2l3b0g', 'BCAE');
        $this->info('Importing party accusations data');
        $data = collect($data)->filter(function ($row) {
            return $row[5] === 'TRUE';
        });
        $progress = $this->output->createProgressBar(count($data));
        foreach ($data as $key => $row) {
            $progress->advance();
            $partyName = $row[9];
            $party = $this->partyNames->firstWhere('mm', $partyName);
            if ($party) {
                $partyName = $party->en;
            }
            PartyAccusation::updateOrCreate([
                'postUrl' => $row[14],
            ], [
                'date' => $row[2],
                'message' => $row[6],
                'message_en' => $row[7],
                'name' => $row[8],
                'partyName' => $partyName,
            ]);
        }
        $progress->finish();
        $this->newLine();
    }

    protected function importUECAccusations(): void
    {
        $data = $this->service->getValuesBySheetName('11QTYO3XHyTvwNZwmYGMBlQ-ZTrwaZ0P9D3h6IUKOAj0', 'Sankey');
        $this->info('Importing UEC accusations data');
        $progress = $this->output->createProgressBar(count($data));
        foreach ($data as $key => $row) {
            $progress->advance();
            if ($key === 0) {
                continue;
            }
            UECAccusation::firstOrCreate([
                'from' => $this->partyNames->firstWhere('mm', $row[0])?->en ?? $row[0],
                'to' => $this->partyNames->firstWhere('mm', $row[1])?->en ?? $row[1],
                'weight' => (int)$row[2],
            ]);
        }
        $progress->finish();
        $this->newLine();
    }
}
