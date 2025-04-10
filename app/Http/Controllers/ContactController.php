<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('contactgegevens.index', compact('contacts'));
    }

    public function create()
    {
        return view('contactgegevens.create');
    }

    public function store(Request $request)
    {
        $query = Contact::query();
    
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
        }
    
        $contacts = $query->get();
    
        $selectedContact = null;
        if ($request->has('contact_id')) {
            $selectedContact = Contact::with('reservations')->find($request->contact_id);
        }
    
        return view('contactgegevens.index', compact('contacts', 'selectedContact'));
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
            'email' => 'required|email|unique:contacts',
            'phone' => 'required|string|max:15',
            'message' => 'nullable|string',
        ]);
    
        Contact::create($request->all());
    
        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }
}