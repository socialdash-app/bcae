<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return \Inertia\Inertia::render('index');
});

\App\Http\Controllers\CorrelatedActionsController::routes();

\App\Http\Controllers\ProminentEventsController::routes();

\App\Http\Controllers\PartyActionsController::routes();

\App\Http\Controllers\TheMilitaryController::routes();
