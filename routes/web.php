<?php

use Illuminate\Support\Facades\Route;
use App\Models\Tournament;
use App\Models\MatchModel;
use App\Models\AsiaTeam;
use App\Services\TeamSyncService;
use App\Http\Controllers\TeamController;

// Redirect root / ke /home
Route::get('/', function () {
    return redirect()->route('home');
});

// Beranda / Dashboard
Route::get('/home', function () {
    return view('home.index');
})->name('home');

// Tournaments
Route::get('/tournaments', function () {
    return view('tournaments.index');
})->name('tournaments.index');

Route::get('/tournaments/{slug}', function ($slug) {
    $tournament = Tournament::with(['matches', 'bracketNodes', 'standings', 'prizeDistributions'])
        ->where('slug', $slug)
        ->firstOrFail();
    return view('tournaments.show', compact('tournament'));
})->name('tournaments.show');

// Teams (Daftar Tim Asia menggunakan Controller)
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');

// Detail Tim Asia
Route::get('/teams/{slug}', function ($slug) {
    $team = AsiaTeam::with(['rosters'])
        ->where('slug', $slug)
        ->firstOrFail();
    return view('teams.show', compact('team'));
})->name('teams.show');

// Detail Match
Route::get('/matches/{id}', function ($id) {
    $match = MatchModel::with('tournament')->where('id', $id)->firstOrFail();

    if (!$match->is_asia_match) {
        abort(404);
    }

    return view('matches.show', compact('match'));
})->name('matches.show');

// Jalur Sinkronisasi Tim dari PandaScore API
Route::get('/run-sync-teams', function (TeamSyncService $service) {
    return $service->autoDiscoverAndSyncAsiaTeams();
});

// Detail Tim Asia menggunakan Controller untuk mengambil data Live API PandaScore
Route::get('/teams/{slug}', [TeamController::class, 'show'])->name('teams.show');
