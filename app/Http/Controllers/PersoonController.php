<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PersoonController extends Controller

{
    public function index(Request $request)
    {
        $datum = $request->input('datum') ?? Carbon::now()->toDateString();

        $personen = DB::table('persoon')
            ->join('contact', 'persoon.id', '=', 'contact.persoonid')
            ->join('typepersoon', 'contact.typepersoonid', '=', 'typepersoon.id')
            ->whereDate('persoon.created_at', '<=', $datum)
            ->orderBy('persoon.achternaam')
            ->select('persoon.naam', 'persoon.achternaam', 'persoon.mobiel', 'contact.emailadres', 'persoon.volwassen')
            ->get();

        if ($personen->isEmpty()) {
            return view('klanten.index', [
                'personen' => [],
                'melding' => 'Er is geen informatie beschikbaar voor deze geselecteerde datum.'
            ]);
        }

        return view('klanten.index', [
            'personen' => $personen,
            'melding' => null
        ]);
        
        
    }
}




