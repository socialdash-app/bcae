<?php

namespace App\Http\Controllers;

use App\Services\ProminentEventsService;
use Illuminate\Support\Facades\Route;

class ProminentEventsController
{
    public static function routes()
    {
        Route::prefix('prominent-events')->group(function () {
            Route::post('election-incidents', fn() => response()->json(ProminentEventsService::getElectionIncidents()));
        });
    }
}
