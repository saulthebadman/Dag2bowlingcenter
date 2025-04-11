<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('reservering.uitslagen');
    }

    public function toonUitslagen(Request $request)
    {
        $validated = $request->validate([
            'datum' => 'required|date',
        ]);

        // Mock data for demonstration purposes
        $uitslagen = collect([
            ['naam' => 'John Doe', 'punten' => 150, 'datum' => '2023-10-01'],
            ['naam' => 'Jane Smith', 'punten' => 200, 'datum' => '2023-10-01'],
            ['naam' => 'Alice Johnson', 'punten' => 180, 'datum' => '2023-10-01'],
        ])->where('datum', $validated['datum'])->sortByDesc('punten');

        return view('reservering.uitslagen', compact('uitslagen'));
    }
}