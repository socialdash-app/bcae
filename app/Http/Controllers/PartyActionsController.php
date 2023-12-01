<?php

namespace App\Http\Controllers;

use App\Models\PartyActions\Party;
use App\Models\PartyActions\PartyAccusation;
use App\Models\PartyActions\UECAccusation;
use Illuminate\Support\Facades\Route;

class PartyActionsController
{
    public static function routes(): void
    {
        Route::group(['prefix' => 'party-actions'], function () {
            Route::post('party-names', [static::class, 'getPartyNames']);
            Route::post('party-accusations', [static::class, 'getPartyAccusationsData']);
            Route::post('uec-accusations', [static::class, 'getUECAccusationsData']);
        });
    }

    public function getPartyNames(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Party::all());
    }

    public function getPartyAccusationsData(): \Illuminate\Http\JsonResponse
    {
        return response()->json(PartyAccusation::all()->groupBy('partyName'));
    }

    public function getUECAccusationsData(): \Illuminate\Http\JsonResponse
    {
        return response()->json(UECAccusation::all()->groupBy('from'));
    }
}
