<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reserveringsoverzicht') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Contactgegevens</h1>

        <!-- Zoekbalk -->
        <form action="{{ route('contacts.index') }}" method="GET" class="mb-6">
            <div class="flex items-center">
                <input 
                    type="text" 
                    name="search" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                    placeholder="Zoek contact..." 
                    value="{{ request('search') }}">
                <button 
                    type="submit" 
                    class="ml-2 px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600">
                    Zoeken
                </button>
            </div>
        </form>

        <a href="{{ route('contacts.create') }}" class="mb-4 inline-block px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
            Nieuw Contact
        </a>

        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Naam</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Email</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Telefoon</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $contact->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $contact->email }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $contact->phone }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            <a href="{{ route('contacts.edit', $contact) }}" class="px-2 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                Bewerken
                            </a>
                            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                                    Verwijderen
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-sm text-gray-500">Geen contacten gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>