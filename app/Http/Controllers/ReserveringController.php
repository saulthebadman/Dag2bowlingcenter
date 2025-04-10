<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReserveringController extends Controller
{
    public function index(Request $request)
    {
        $zoekterm = $request->input('zoek');
        $reserveringen = collect(DB::select('CALL SP_GetReserveringen()'));

        if ($zoekterm) {
            $reserveringen = $reserveringen->filter(function ($res) use ($zoekterm) {
                return str_contains(strtolower($res->klant_naam), strtolower($zoekterm)) ||
                       str_contains(strtolower($res->reserveringsnummer), strtolower($zoekterm)); // Zoek ook op reserveringsnummer
            });
        }

        return view('reserveringen.index', compact('reserveringen', 'zoekterm'));
    }

    public function create()
    {
        $banen = DB::table('banen')->get(); // Haal alle banen op
        return view('reserveringen.create', compact('banen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'klant_naam' => 'required|string|max:255',
            'telefoonnummer' => 'required|string|max:20',
            'datum' => 'required|date',
            'tijd' => 'required',
            'aantal_personen' => 'required|integer|min:1',
            'baan_id' => 'required|exists:banen,id',
            'opmerking' => 'nullable|string',
            'opties' => 'nullable|array',
            'betaling_op_locatie' => 'nullable|boolean',
        ]);

        try {
            // Controleer op conflicten
            $conflict = DB::table('reserveringen')
                ->where('baan_id', $request->baan_id)
                ->where('datum', $request->datum)
                ->where('tijd', $request->tijd)
                ->exists();

            if ($conflict) {
                return back()->withErrors(['error' => 'De gekozen baan is al gereserveerd op deze datum en tijd.'])->withInput();
            }

            $tarief = $this->berekenTarief($request->datum, $request->tijd);
            $magicBowlen = $this->isMagicBowlen($request->datum, $request->tijd);

            if ($tarief == 0.00) {
                return back()->withErrors(['error' => 'De gekozen tijd valt buiten de openingstijden.'])->withInput();
            }

            DB::table('reserveringen')->insert([
                'klant_id' => $this->getKlantId($request->klant_naam, $request->telefoonnummer),
                'baan_id' => $request->baan_id,
                'datum' => $request->datum,
                'tijd' => $request->tijd,
                'aantal_personen' => $request->aantal_personen,
                'opmerking' => $request->opmerking,
                'tarief' => $tarief,
                'opties' => json_encode($request->opties),
                'betaling_op_locatie' => $request->has('betaling_op_locatie'),
                'magic_bowlen' => $magicBowlen,
            ]);

            return redirect()->route('reserveringen.index')->with('success', 'Je reservering is succesvol gemaakt!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Er is een onverwachte fout opgetreden. Probeer het later opnieuw.']);
        }
    }

    public function edit($id)
    {
        $reservering = DB::table('reserveringen')
            ->join('klanten', 'reserveringen.klant_id', '=', 'klanten.id')
            ->join('banen', 'reserveringen.baan_id', '=', 'banen.id')
            ->select(
                'reserveringen.*',
                'klanten.naam as klant_naam',
                'klanten.telefoonnummer',
                'banen.nummer as baan_nummer'
            )
            ->where('reserveringen.id', $id)
            ->first();

        if (!$reservering) {
            return redirect()->route('reserveringen.index')->with('error', 'Reservering niet gevonden');
        }

        $banen = DB::table('banen')->get(); // Haal alle banen op
        return view('reserveringen.edit', compact('reservering', 'banen'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'klant_naam' => 'required|string|max:255',
            'telefoonnummer' => 'required|string|max:20',
            'datum' => 'required|date',
            'tijd' => 'required',
            'aantal_personen' => 'required|integer|min:1',
            'baan_id' => 'required|exists:banen,id',
            'opmerking' => 'nullable|string',
            'opties' => 'nullable|array',
            'betaling_op_locatie' => 'nullable|boolean',
        ]);

        try {
            // Controleer op conflicten
            $conflict = DB::table('reserveringen')
                ->where('baan_id', $request->baan_id)
                ->where('datum', $request->datum)
                ->where('tijd', $request->tijd)
                ->where('id', '!=', $id) // Uitsluiten van de huidige reservering
                ->exists();

            if ($conflict) {
                return back()->withErrors(['error' => 'De gekozen baan is al gereserveerd op deze datum en tijd.'])->withInput();
            }

            $tarief = $this->berekenTarief($request->datum, $request->tijd);
            $magicBowlen = $this->isMagicBowlen($request->datum, $request->tijd);

            DB::table('reserveringen')
                ->where('id', $id)
                ->update([
                    'klant_id' => $this->getKlantId($request->klant_naam, $request->telefoonnummer),
                    'baan_id' => $request->baan_id,
                    'datum' => $request->datum,
                    'tijd' => $request->tijd,
                    'aantal_personen' => $request->aantal_personen,
                    'opmerking' => $request->opmerking,
                    'tarief' => $tarief,
                    'opties' => json_encode($request->opties),
                    'betaling_op_locatie' => $request->has('betaling_op_locatie'),
                    'magic_bowlen' => $magicBowlen,
                ]);

            return redirect()->route('reserveringen.index')->with('success', 'Reservering succesvol bijgewerkt!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Er is een onverwachte fout opgetreden. Probeer het later opnieuw.']);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('reserveringen')->where('id', $id)->delete();
            return redirect()->route('reserveringen.index')->with('success', 'Reservering verwijderd');
        } catch (\Exception $e) {
            return redirect()->route('reserveringen.index')->with('error', 'Verwijderen mislukt: ' . $e->getMessage());
        }
    }

    private function berekenTarief($datum, $tijd)
    {
        $dag = date('N', strtotime($datum)); // 1 = maandag, 7 = zondag
        $uur = intval(date('H', strtotime($tijd))); // Haal het uur op als integer

        if ($dag >= 1 && $dag <= 4) {
            // Maandag t/m donderdag
            return 24.00;
        } elseif ($dag >= 5 && $dag <= 7) {
            // Vrijdag t/m zondag
            if ($uur >= 14 && $uur < 18) {
                return 28.00; // 14:00 - 18:00
            } elseif ($uur >= 18 && $uur <= 24) {
                return 33.50; // 18:00 - 24:00
            }
        }

        return 0.00; // Buiten openingstijden
    }

    private function isMagicBowlen($datum, $tijd)
    {
        $dag = date('N', strtotime($datum)); // 1 = maandag, 7 = zondag
        $uur = intval(date('H', strtotime($tijd)));

        return ($dag >= 5 && $dag <= 7 && $uur >= 22 && $uur <= 24);
    }

    private function getKlantId($klantNaam, $telefoonnummer)
    {
        $klant = DB::table('klanten')
            ->where('naam', $klantNaam)
            ->where('telefoonnummer', $telefoonnummer)
            ->first();

        if (!$klant) {
            return DB::table('klanten')->insertGetId([
                'naam' => $klantNaam,
                'telefoonnummer' => $telefoonnummer,
            ]);
        }

        return $klant->id;
    }
}
