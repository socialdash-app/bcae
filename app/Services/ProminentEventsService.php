<?php

namespace App\Services;

use App\Models\ProminentEvents\ElectionIncident;

class ProminentEventsService
{
    public static function getElectionIncidents(): \Illuminate\Database\Eloquent\Collection
    {
        return ElectionIncident::all();
    }
}
