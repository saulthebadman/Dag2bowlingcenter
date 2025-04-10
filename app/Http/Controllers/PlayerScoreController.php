<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerScoreController extends Controller
{
    public function index(Request $request)
    {
        $players = Player::all();
        $selectedPlayer = null;
        $scores = [];
        $error = null;

        if ($request->has('player') && $request->player) {
            try {
                $selectedPlayer = Player::with('scores')->findOrFail($request->player);
                $scores = $selectedPlayer->scores()->orderByDesc('scored_at')->get();
            } catch (\Exception $e) {
                $error = "Er is iets misgegaan bij het laden van de scores. Probeer later opnieuw.";
            }
        }

        return view('playerscores', compact('players', 'selectedPlayer', 'scores', 'error'));
    }
}
