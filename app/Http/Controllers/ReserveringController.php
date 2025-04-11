<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReserveringController extends Controller
{
    public function index()
    {
        // Mock data for demonstration purposes
        $reserveringen = [
            (object) ['id' => 1, 'naam' => 'John Doe', 'datum' => '2023-10-01'],
            (object) ['id' => 2, 'naam' => 'Jane Smith', 'datum' => '2023-10-02'],
        ];

        return view('reservering.index', compact('reserveringen'));
    }

    public function edit($id)
    {
        // Mock data for demonstration purposes
        $reservering = (object) ['id' => $id, 'naam' => 'John Doe', 'datum' => '2023-10-01'];

        return view('reservering.edit', compact('reservering'));
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