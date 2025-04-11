<?php

namespace App\Http\Controllers;

use App\Models\Reservering;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReserveringRequest;
use App\Http\Requests\UpdateReserveringRequest;

class ReserveringController extends Controller
{
    public function index()
    {
        $reserveringen = Reservering::all(); // Fetch all reservations
        return view('reserveringen.index', compact('reserveringen'));
    }

    public function edit(Reservering $reservering)
    {
        $this->authorize('update', $reservering);
        return view('reserveringen.edit', compact('reservering'));
    }

    public function update(UpdateReserveringRequest $request, Reservering $reservering)
    {
        $this->authorize('update', $reservering);
        $reservering->update($request->validated());

        return redirect()->route('reserveringen.index')
                         ->with('success', 'Je reservering is aangepast.');
    }

    public function create()
    {
        return view('reserveringen.create');
    }

    public function store(StoreReserveringRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        Reservering::create($validated);

        return redirect()->route('reserveringen.index')->with('success', 'Reservering succesvol aangemaakt!');
    }

    public function confirmedReservations(Request $request)
    {
        $date = $request->input('date', now()); // Default to current date if no date is provided
        $reserveringen = Reservering::where('status', 'confirmed')
            ->whereDate('created_at', '<=', $date)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reserveringen.overview', compact('reserveringen', 'date'));
    }

    public function editLane(Reservering $reservering)
    {
        return view('reserveringen.edit-lane', compact('reservering'));
    }

    public function updateLane(Request $request, Reservering $reservering)
    {
        $request->validate([
            'baannummer' => ['required', 'integer', 'min:1'],
        ]);

        // Check if the selected lane is unsuitable for children
        $unsuitableLanes = [7, 8]; // Lanes without bumpers
        if (in_array($request->input('baannummer'), $unsuitableLanes)) {
            return redirect()->back()
                             ->withErrors(['baannummer' => 'Deze baan is ongeschikt voor kinderen omdat deze geen hekjes heeft.'])
                             ->withInput();
        }

        $reservering->update([
            'baannummer' => $request->input('baannummer'),
        ]);

        return redirect()->route('reserveringen.overview')
                         ->with('success', 'Het baannummer is gewijzigd.');
    }
}
