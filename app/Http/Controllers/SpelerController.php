<?php


namespace App\Http\Controllers;

use App\Models\Uitslag;
use Illuminate\Http\Request ;

class SpelerController extends Controller
{
    public function index()
    {
        // Haal alle uitslagen op met gekoppelde spelers
        $uitslagen = Uitslag::with('spel.reservering.persoon')->get();

        return view('spelers.index', compact('uitslagen'));
    }

    public function edit($id)
    {
        // Haal de uitslag op
        $uitslag = Uitslag::with('spel.reservering.persoon')->findOrFail($id);

        return view('spelers.edit', compact('uitslag'));
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'aantal_punten' => 'required|integer|min:0|max:300',
        ], [
            'aantal_punten.max' => 'Het aantal punten is niet geldig, voer een waarde in kleiner of gelijk aan 300.',
        ]);

        // Update de uitslag
        $uitslag = Uitslag::findOrFail($id);
        $uitslag->update($request->only('aantal_punten'));

        return redirect()->route('spelers.index')->with('success', 'Aantal punten is gewijzigd.');
    }
}
