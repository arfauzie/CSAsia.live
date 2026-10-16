<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tournament;
use App\Services\TournamentSyncService;

class TournamentHub extends Component
{
    public $statusFilter = 'all';

    public function mount(TournamentSyncService $tournamentSync)
    {
        // Panggil sinkronisasi khusus turnamen Alter Ego (ID: 135214)
        $tournamentSync->syncTournamentsForAlterEgo();
    }

    public function render()
    {
        $query = Tournament::query();

        if ($this->statusFilter === 'ongoing') {
            $query->where('status', 'ongoing');
        } elseif ($this->statusFilter === 'upcoming') {
            $query->where('status', 'upcoming');
        }

        $tournaments = $query->orderBy('start_date', 'asc')->get();

        return view('components.tournament-hub', [
            'tournaments' => $tournaments
        ]);
    }
}
