<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class NavigationController
{
    public static function routes(): void
    {
        Route::get('/', self::class);
    }

    public function __invoke(): Response
    {
        return Inertia::render('pages/navigation');
    }
}
