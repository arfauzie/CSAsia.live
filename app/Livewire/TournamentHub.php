<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tournament;
use App\Services\TournamentSyncService;

class TournamentHub extends Component
{
    public $statusFilter = 'all';

    protected $queryString = ['statusFilter'];

    public function mount(TournamentSyncService $tournamentSync)
    {
        // Panggil method yang benar sesuai service kita: syncTournaments()
        $tournamentSync->syncTournaments();
    }

    public function render()
    {
        $query = Tournament::query();

        if ($this->statusFilter === 'ongoing') {
            $query->where('status', 'ongoing');
        } elseif ($this->statusFilter === 'upcoming') {
            $query->where('status', 'upcoming');
        } else {
            $query->where('status', '!=', 'finished');
        }

        $tournaments = $query->orderBy('start_date', 'asc')->get();

        return view('components.tournament-hub', compact('tournaments'));
    }
}
