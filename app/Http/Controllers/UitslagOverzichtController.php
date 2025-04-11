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

    public function index(Request $request)
    {
        // Haal de filterwaarde op
        $filter = $request->input('filter', '');

        // Haal reserveringen op met gekoppelde persoon, spellen en uitslagen
        $reserveringen = Reservering::with(['persoon', 'spellen.uitslagen'])
            ->whereHas('persoon', function ($query) use ($filter) {
                if (!empty($filter)) {
                    $query->where('voornaam', 'like', "%$filter%")
                          ->orWhere('achternaam', 'like', "%$filter%");
                }
            })
            ->get();

        // Retourneer de juiste view met de data en filter
        return view('uitslagoverzicht.index', compact('reserveringen', 'filter'));
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
            // Haal de reservering op met gekoppelde spellen en uitslagen
            $reservering = Reservering::with(['persoon', 'spellen.uitslagen.persoon'])->findOrFail($id);

            // Haal de uitslagen op, gesorteerd van hoog naar laag
            $uitslagen = $reservering->spellen->flatMap->uitslagen->sortByDesc('aantal_punten');

            // Controleer of er uitslagen zijn
            if ($uitslagen->isEmpty()) {
                return redirect()->route('uitslagoverzicht.index')->with('error', 'Van de geselecteerde reservering zijn geen uitslagen bekend.');
            }

            // Toon de uitslagen
            return view('uitslagoverzicht.show', compact('reservering', 'uitslagen'));
        } catch (\Exception $e) {
            // Foutafhandeling
            return redirect()->route('uitslagoverzicht.index')->with('error', 'Er is een fout opgetreden bij het ophalen van de uitslagen.');
        }
    }
}
