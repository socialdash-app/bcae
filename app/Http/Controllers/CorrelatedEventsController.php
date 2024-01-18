<?php

namespace App\Http\Controllers;

use App\Models\CorrelatedActions\Protest;
use App\Services\CorrelatedActionsService;
use Illuminate\Support\Facades\Route;

class CorrelatedEventsController
{
    public static function routes(): void
    {
        Route::group(['prefix' => 'correlated-events'], function () {
            Route::post('protests', [static::class, 'getProtestData']);
            Route::post('disinformation', [static::class, 'disinformation']);
        });
    }

    public function getProtestData(): \Illuminate\Http\JsonResponse
    {
        return response()->json(CorrelatedActionsService::getProtestData());
    }

    public function disinformation(): \Illuminate\Http\JsonResponse
    {
        return response()->json(CorrelatedActionsService::getDisinformationData());
    }
}
