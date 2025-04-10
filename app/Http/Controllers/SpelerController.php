<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Speler; // 👈 hier moet die staan!

class SpelerController extends Controller
{
    public function index()
    {
        $spelers = Speler::all();
        return view('spelers.index', compact('spelers'));
    }

    public function show($id)
    {
        $speler = Speler::with('scores')->findOrFail($id);
        return view('spelers.show', compact('speler'));
    }
}
