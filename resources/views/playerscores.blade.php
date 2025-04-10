<?php
// app/Http/Livewire/PlayerScores.php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Player;

class PlayerScores extends Component
{
    public $players;
    public $selectedPlayerId;
    public $scores = [];
    public $error;

    public function mount()
    {
        $this->players = Player::all();
    }

    public function selectPlayer($playerId)
    {
        try {
            $player = Player::with('scores')->findOrFail($playerId);
            $this->selectedPlayerId = $playerId;
            $this->scores = $player->scores->sortByDesc('scored_at');
            $this->error = null;
        } catch (\Exception $e) {
            $this->scores = [];
            $this->error = "Er is iets misgegaan bij het laden van de scores. Probeer later opnieuw.";
        }
    }

    public function render()
    {
        return view('livewire.player-scores');
    }
}

@extends('layouts.app') {{-- Zorg dat dit bestaat of pas aan naar jouw layout --}}

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Spelers & Scores</h1>

        <form method="GET" action="{{ route('playerscores') }}" class="mb-6">
            <label for="player" class="block mb-2 font-semibold">Kies een speler:</label>
            <select name="player" id="player" class="p-2 border rounded" onchange="this.form.submit()">
                <option value="">-- Selecteer speler --</option>
                @foreach($players as $player)
                    <option value="{{ $player->id }}" {{ $selectedPlayer && $selectedPlayer->id == $player->id ? 'selected' : '' }}>
                        {{ $player->name }}
                    </option>
                @endforeach
            </select>
        </form>

        @if($error)
            <div class="text-red-600">{{ $error }}</div>
        @elseif($selectedPlayer)
            <h2 class="text-xl font-semibold mb-2">Scores van {{ $selectedPlayer->name }}</h2>

            @if(count($scores))
                <table class="table-auto w-full border">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Datum</th>
                            <th class="px-4 py-2">Score</th>
                            <th class="px-4 py-2">Modus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scores as $score)
                            <tr>
                                <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($score->scored_at)->format('d-m-Y') }}</td>
                                <td class="border px-4 py-2">{{ $score->value }}</td>
                                <td class="border px-4 py-2">{{ $score->mode }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Geen scores beschikbaar voor deze speler.</p>
            @endif
        @endif
    </div>
@endsection

?>