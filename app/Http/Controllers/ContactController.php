<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $contacts = Contact::when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
        })->get();

        $message = null;
        if ($search && $contacts->isEmpty()) {
            $message = 'Geen klant gevonden. Controleer de invoer of probeer een andere zoekterm.';
        }

        return view('contactgegevens.index', compact('contacts', 'search', 'message'));
    }

    public function create()
    {
        return view('contactgegevens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts',
            'phone' => 'required|string|digits_between:8,11',
            'message' => 'nullable|string',
        ], [
            'name.required' => 'De naam is verplicht.',
            'email.required' => 'Het e-mailadres is verplicht.',
            'email.email' => 'Voer een geldig e-mailadres in.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
            'phone.required' => 'Het telefoonnummer is verplicht.',
            'phone.digits_between' => 'Het telefoonnummer moet minimaal 8 en maximaal 11 cijfers bevatten.',
        ]);

        Contact::create($request->all());

        // Zorg ervoor dat er slechts één melding wordt weergegeven
        session()->forget('success');
        return redirect()->route('contacts.index')->with('success', 'Contact succesvol toegevoegd.');
    }
    
    public function show(Contact $contact)
    {
        $reservations = $contact->reservations; // Zorg dat de relatie is gedefinieerd in het model
        return view('contactgegevens.show', compact('contact', 'reservations'));
    }

    public function edit(Contact $contact)
    {
        return view('contactgegevens.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email,' . $contact->id,
            'phone' => 'required|string|digits_between:8,11',
            'message' => 'nullable|string',
        ], [
            'email.required' => 'Het e-mailadres is verplicht.',
            'email.email' => 'Voer een geldig e-mailadres in.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
            'phone.digits_between' => 'Het telefoonnummer moet minimaal 8 en maximaal 11 cijfers bevatten.',
        ]);

        $contact->update($request->all());

        // Zorg ervoor dat er slechts één melding wordt weergegeven
        session()->forget('success');
        return redirect()->route('contacts.index')->with('success', 'Klantgegevens succesvol bijgewerkt.');
    }

    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            return redirect()->route('contacts.index')->with('success', 'Klantgegevens succesvol verwijderd.');
        } catch (\Exception $e) {
            return redirect()->route('contacts.index')->with('error', 'Er is een fout opgetreden bij het verwijderen van de klant.');
        }
    }
}