<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReserveringController extends Controller
{
    public function index()
    {
        // Updated mock data to include more entries
        $reserveringen = [
            (object) [
                'id' => 1,
                'naam' => 'Mazin Jamil',
                'datum' => '2023-10-01',
                'aantal_volwassenen' => 2,
                'aantal_kinderen' => 3,
                'optiepakket' => 'Snackpakketbasis',
            ],
            (object) [
                'id' => 2,
                'naam' => 'Arjan de Ruijter',
                'datum' => '2023-10-02',
                'aantal_volwassenen' => 4,
                'aantal_kinderen' => 2,
                'optiepakket' => 'Kinderpartij',
            ],
            (object) [
                'id' => 3,
                'naam' => 'Hans Odijk',
                'datum' => '2023-10-03',
                'aantal_volwassenen' => 3,
                'aantal_kinderen' => 1,
                'optiepakket' => 'Snackpakketluxe',
            ],
            (object) [
                'id' => 4,
                'naam' => 'Dennis Van Wakeren',
                'datum' => '2023-10-04',
                'aantal_volwassenen' => 5,
                'aantal_kinderen' => 0,
                'optiepakket' => 'Vrijgezellenfeest',
            ],
            (object) [
                'id' => 5,
                'naam' => 'Wilco Van de Grift',
                'datum' => '2023-10-05',
                'aantal_volwassenen' => 2,
                'aantal_kinderen' => 4,
                'optiepakket' => 'Kinderpartij',
            ],
        ];

        return view('reservering.index', compact('reserveringen'));
    }

    public function edit($id)
    {
        // Mock data for demonstration purposes
        $reservering = (object) [
            'id' => $id,
            'naam' => 'John Doe',
            'datum' => '2023-10-01',
            'optiepakket_id' => 1, // Current package option ID
        ];

        // Mock available package options
        $pakketopties = [
            (object) ['id' => 1, 'naam' => 'Snackpakketbasis'],
            (object) ['id' => 2, 'naam' => 'Snackpakketluxe'],
            (object) ['id' => 3, 'naam' => 'Kinderpartij'],
            (object) ['id' => 4, 'naam' => 'Vrijgezellenfeest'],
        ];

        return view('reservering.edit', compact('reservering', 'pakketopties'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'optiepakket_id' => 'required|integer|exists:PakketOptie,Id',
        ]);

        // Update the reservering's pakketoptie in the database
        $updated = DB::table('Reservering')
            ->where('Id', $id)
            ->update(['PakketOptieId' => $validated['optiepakket_id']]);

        if ($updated) {
            return redirect()->route('reservering.index')->with('success', 'Het optiepakket is gewijzigd');
        } else {
            return redirect()->route('reservering.index')->with('error', 'Er is een fout opgetreden bij het wijzigen van het optiepakket');
        }
    }

    public function uitslagen()
    {
        $uitslagen = []; // Ensure $uitslagen is defined as an empty array
        return view('reservering.uitslagen', compact('uitslagen'));
    }

    public function toonUitslagen(Request $request)
    {
        $validated = $request->validate([
            'datum' => 'nullable|date',
        ]);

        // Fetch data using the stored procedure
        $uitslagen = DB::select('CALL SP_OverzichtUitslagenPerReservering(?)', [
            $validated['datum'] ?? null,
        ]);

        return view('reservering.uitslagen', compact('uitslagen'));
    }
}