<?php

namespace App\Http\Controllers;

use App\Services\CorrelatedActionsService;
use Illuminate\Support\Facades\Route;

class CorrelatedActionsController
{
    public static function routes(): void
    {
        Route::group(['prefix' => 'correlated-actions'], function () {
            Route::post('disinformation', [static::class, 'disinformation']);
        });
    }

    public function disinformation(): \Illuminate\Http\JsonResponse
    {
        return response()->json(CorrelatedActionsService::getDisinformationData());
    }
}
