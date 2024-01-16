<?php

namespace App\Console\Commands;

use App\Services\CorrelatedActionsService;
use Illuminate\Console\Command;

class Playground extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:playground';

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
        dd(CorrelatedActionsService::getDisinformationData());

        $data = [];
        Type::all()->each(function ($type) use (&$data) {
            $data[$type->name] = $type->formattedMapData;
        });
    }
}
