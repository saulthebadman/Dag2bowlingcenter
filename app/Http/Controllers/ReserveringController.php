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
        return view('reserveringen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'klant_naam' => 'required|string|max:255',
            'telefoonnummer' => 'required|string|max:20',
            'datum' => 'required|date',
            'tijd' => 'required',
            'aantal_personen' => 'required|integer|min:1',
            'opmerking' => 'nullable|string',
            'betaling_op_locatie' => 'nullable|boolean',
        ]);

        try {
            // Controleer op dubbele reservering
            $existingReservation = DB::table('reserveringen')
                ->join('klanten', 'reserveringen.klant_id', '=', 'klanten.id')
                ->where('klanten.naam', $request->klant_naam)
                ->where('klanten.telefoonnummer', $request->telefoonnummer)
                ->where('reserveringen.datum', $request->datum)
                ->where('reserveringen.tijd', $request->tijd)
                ->first();

            if ($existingReservation) {
                return back()->withErrors(['error' => 'Je hebt al een reservering op deze datum en tijd.'])->withInput();
            }

            // Voeg klant toe of haal bestaande klant op
            $klant = DB::table('klanten')
                ->where('naam', $request->klant_naam)
                ->where('telefoonnummer', $request->telefoonnummer)
                ->first();

            if (!$klant) {
                $klant_id = DB::table('klanten')->insertGetId([
                    'naam' => $request->klant_naam,
                    'telefoonnummer' => $request->telefoonnummer,
                ]);
            } else {
                $klant_id = $klant->id;
            }

            $tarief = $this->berekenTarief($request->datum, $request->tijd);

            if ($tarief == 0.00) {
                return back()->withErrors(['error' => 'De gekozen tijd valt buiten de openingstijden.'])->withInput();
            }

            // Voeg reservering toe met tarief en betaling_op_locatie
            DB::select('CALL SP_InsertReservering(?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->klant_naam,
                $request->telefoonnummer,
                $request->datum,
                $request->tijd,
                $request->aantal_personen,
                $request->opmerking,
                $tarief,
                $request->has('betaling_op_locatie') ? 1 : 0
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
            ->select(
                'reserveringen.*',
                'klanten.naam as klant_naam',
                'klanten.telefoonnummer'
            )
            ->where('reserveringen.id', $id)
            ->first();

        if (!$reservering) {
            return redirect()->route('reserveringen.index')->with('error', 'Reservering niet gevonden');
        }

        return view('reserveringen.edit', compact('reservering'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'klant_naam' => 'required|string|max:255',
            'telefoonnummer' => 'required|string|max:20',
            'datum' => 'required|date',
            'tijd' => 'required',
            'aantal_personen' => 'required|integer|min:1',
            'opmerking' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Zoek of voeg klant toe
            $klant = DB::table('klanten')
                ->where('naam', $request->klant_naam)
                ->where('telefoonnummer', $request->telefoonnummer)
                ->first();

            if (!$klant) {
                $klant_id = DB::table('klanten')->insertGetId([
                    'naam' => $request->klant_naam,
                    'telefoonnummer' => $request->telefoonnummer,
                ]);
            } else {
                $klant_id = $klant->id;
            }

            // Update reservering
            DB::statement('CALL SP_UpdateReservering(?, ?, ?, ?, ?, ?)', [
                $id,
                $klant_id,
                $request->datum,
                $request->tijd,
                $request->aantal_personen,
                $request->opmerking,
            ]);

            return redirect()->route('reserveringen.index')->with('success', 'Reservering succesvol bijgewerkt!');
        } catch (\Exception $e) {
            return back()->with('error', 'Fout bij bijwerken: ' . $e->getMessage());
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
}
