<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tournament;
use App\Services\TournamentSyncService;

class TournamentHub extends Component
{
    public function mount(TournamentSyncService $tournamentSync)
    {
        // 1. Jalankan sync turnamen Alter Ego saat komponen dimuat (atau bisa dipindah ke cron/command nanti)
        // Ganti 1234 dengan ID PandaScore Alter Ego yang sebenarnya
        $tournamentSync->syncTournamentsForAlterEgo(135214);
    }

    public function render()
    {
        // 2. Ambil data dari database lokal untuk dilempar ke view Livewire
        $tournaments = Tournament::where('status', '!=', 'finished')->get();

        return view('livewire.tournament-hub', compact('tournaments'));
    }
}
