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
                return str_contains(strtolower($res->klant_naam), strtolower($zoekterm));
            });
        }

        return view('reserveringen.index', compact('reserveringen', 'zoekterm'));
    }

    public function create()
    {
        $klanten = DB::table('klanten')->get();
        $banen = DB::table('banen')->get();
        return view('reserveringen.create', compact('klanten', 'banen'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'klant_id' => 'required|integer|exists:klanten,id',
            'baan_id' => 'required|integer|exists:banen,id',
            'datum' => 'required|date',
            'tijd' => 'required',
            'aantal_personen' => 'required|integer|min:1',
            'opmerking' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::statement('CALL SP_InsertReservering(?, ?, ?, ?, ?, ?)', [
                $request->klant_id,
                $request->baan_id,
                $request->datum,
                $request->tijd,
                $request->aantal_personen,
                $request->opmerking,
            ]);

            return redirect()->route('reserveringen.index')->with('success', 'Reservering succesvol aangemaakt!');
        } catch (\Exception $e) {
            return back()->with('error', 'Fout bij opslaan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $reservering = DB::table('reserveringen')->where('id', $id)->first();
        $klanten = DB::table('klanten')->get();
        $banen = DB::table('banen')->get();

        if (!$reservering) {
            return redirect()->route('reserveringen.index')->with('error', 'Reservering niet gevonden');
        }

        return view('reserveringen.edit', compact('reservering', 'klanten', 'banen'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'klant_id' => 'required|integer|exists:klanten,id',
            'baan_id' => 'required|integer|exists:banen,id',
            'datum' => 'required|date',
            'tijd' => 'required',
            'aantal_personen' => 'required|integer|min:1',
            'opmerking' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::statement('CALL SP_UpdateReservering(?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $request->klant_id,
                $request->baan_id,
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
}
