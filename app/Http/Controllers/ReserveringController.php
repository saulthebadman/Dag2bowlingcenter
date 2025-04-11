<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReserveringController extends Controller
{
    use App\Models\Reservering;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateReserveringRequest;

class ReserveringController extends Controller
{
    public function edit(Reservering $reservering)
    {
        $this->authorize('update', $reservering);
        return view('reserveringen.edit', compact('reservering'));
    }

    public function update(UpdateReserveringRequest $request, Reservering $reservering)
    {
        $this->authorize('update', $reservering);
        $reservering->update($request->validated());

        return redirect()->route('reserveringen.index')
                         ->with('success', 'Je reservering is aangepast.');
    }
}

}
