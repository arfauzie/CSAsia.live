<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tournament;

class TournamentHub extends Component
{
    public $search = '';
    public $statusFilter = 'all'; // all, ongoing, upcoming

    public function render()
    {
        $query = Tournament::query();

        // Filter status (hanya ongoing & upcoming sesuai spesifikasi)
        if ($this->statusFilter === 'ongoing') {
            $query->where('status', 'ongoing');
        } elseif ($this->statusFilter === 'upcoming') {
            $query->where('status', 'upcoming');
        } else {
            $query->whereIn('status', ['ongoing', 'upcoming']);
        }

        // Filter pencarian nama turnamen
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $tournaments = $query->get();

        return view('components.tournament-hub', [
            'tournaments' => $tournaments
        ]);
    }
}
