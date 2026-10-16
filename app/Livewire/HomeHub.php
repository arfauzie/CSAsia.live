<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tournament;

class HomeHub extends Component
{
    public function render()
    {
        // Mengambil turnamen yang memiliki relasi matches (Strict Asia Filter)
        $tournaments = Tournament::with(['matches' => function ($query) {
            $query->orderBy('start_time', 'asc');
        }])->whereIn('status', ['ongoing', 'upcoming'])->get();

        return view('components.home-hub', [
            'tournaments' => $tournaments
        ]);
    }
}
