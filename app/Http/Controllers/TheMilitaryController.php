<?php

namespace App\Http\Controllers;

use App\Models\TheMilitary\DsInfoPost;
use Illuminate\Support\Facades\Route;

class TheMilitaryController
{
    public static function routes()
    {
        Route::prefix('the-military')->group(function () {
            Route::post('statements', [static::class, 'getStatements']);
        });
    }

    public function getStatements()
    {
        $statements = DSInfoPost::where('type', 'regexp', '/^(\d+)(.*)statement$/i')->get();
        $importantStatements = DSInfoPost::where('isImportant', true)->get();
        return response()->json($statements->merge($importantStatements)->sortBy('date')->toArray());
    }
}
