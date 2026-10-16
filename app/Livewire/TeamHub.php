<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AsiaTeam;

class TeamHub extends Component
{
    public $search = '';

    public function render()
    {
        $query = AsiaTeam::where('is_active', true);

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Urutkan berdasarkan valve_ranking (yang punya ranking di atas), 
        // lalu fallback urutkan berdasarkan nama jika ranking kosong
        $teams = $query->orderByRaw('valve_ranking IS NULL, valve_ranking ASC')
            ->orderBy('name', 'asc')
            ->get();

        return view('components.team-hub', [
            'teams' => $teams
        ]);
    }
}
