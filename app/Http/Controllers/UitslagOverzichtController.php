<?php

namespace App\Http\Controllers;

use App\Models\UitslagOverzicht;
use App\Models\Spel;
use App\Models\Persoon;
use App\Models\Reservering; // Zorg ervoor dat deze regel aanwezig is
use Illuminate\Http\Request;

class UitslagOverzichtController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Haal reserveringen op (pas dit aan naar jouw logica)
        $reserveringen = Reservering::all();

        // Retourneer de juiste view
        return view('uitslagoverzicht.index', compact('reserveringen'));
    }

    public function create()
    {
        $spellen = Spel::all();
        $personen = Persoon::all();
        return view('uitslagoverzicht.create', compact('spellen', 'personen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'spel_id' => 'required|exists:spellen,id',
            'persoon_id' => 'required|exists:personen,id',
            'aantal_punten' => 'required|integer|min:0',
        ]);

        UitslagOverzicht::create($request->all());
        return redirect()->route('uitslagoverzicht.index')->with('success', 'Uitslag toegevoegd.');
    }

    public function edit(UitslagOverzicht $uitslagOverzicht)
    {
        $spellen = Spel::all();
        $personen = Persoon::all();
        return view('uitslagoverzicht.edit', compact('uitslagOverzicht', 'spellen', 'personen'));
    }

    public function update(Request $request, UitslagOverzicht $uitslagOverzicht)
    {
        $request->validate([
            'spel_id' => 'required|exists:spellen,id',
            'persoon_id' => 'required|exists:personen,id',
            'aantal_punten' => 'required|integer|min:0',
        ]);

        $uitslagOverzicht->update($request->all());
        return redirect()->route('uitslagoverzicht.index')->with('success', 'Uitslag bijgewerkt.');
    }

    public function destroy(UitslagOverzicht $uitslagOverzicht)
    {
        $uitslagOverzicht->delete();
        return redirect()->route('uitslagoverzicht.index')->with('success', 'Uitslag verwijderd.');
    }

    public function showByReservering($id)
    {
        try {
            // Haal de reservering op
            $reservering = Reservering::findOrFail($id);

            // Haal de uitslagen op, gesorteerd van hoog naar laag
            $uitslagen = UitslagOverzicht::whereHas('spel', function ($query) use ($id) {
                $query->where('reservering_id', $id);
            })
            ->with(['persoon', 'spel'])
            ->orderBy('aantal_punten', 'desc')
            ->get();

            // Controleer of er uitslagen zijn
            if ($uitslagen->isEmpty()) {
                return redirect()->back()->with('error', 'Van de geselecteerde reservering zijn geen uitslagen bekend.');
            }

            // Toon de uitslagen
            return view('uitslagoverzicht.reservering', compact('reservering', 'uitslagen'));
        } catch (\Exception $e) {
            // Foutafhandeling
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het ophalen van de uitslagen.');
        }
    }
}
