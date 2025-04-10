<x-app-layout>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Overzicht Reserveringen</h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="GET" action="{{ route('reserveringen.index') }}" class="mb-4 flex gap-2">
        <input type="text" name="zoek" value="{{ request('zoek') }}"
            placeholder="Zoek op klantnaam..."
            class="border rounded px-4 py-2 w-1/3 focus:outline-none focus:ring">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Zoeken
        </button>
        <a href="{{ route('reserveringen.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Nieuwe Reservering
        </a>
    </form>

    <table class="min-w-full bg-white shadow-md rounded overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">Reserveringsnummer</th>
                <th class="px-4 py-2 border">Klant</th>
                <th class="px-4 py-2 border">Telefoon</th>
                <th class="px-4 py-2 border">Baan</th>
                <th class="px-4 py-2 border">Datum</th>
                <th class="px-4 py-2 border">Tijd</th>
                <th class="px-4 py-2 border">Aantal Personen</th>
                <th class="px-4 py-2 border">Opmerking</th>
                <th class="px-4 py-2 border">Acties</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reserveringen as $res)
                <tr>
                    <td class="border px-4 py-2">{{ $res->id }}</td>
                    <td class="border px-4 py-2 font-mono text-sm">{{ $res->reserveringsnummer }}</td>
                    <td class="border px-4 py-2">{{ $res->klant_naam }}</td>
                    <td class="border px-4 py-2">{{ $res->telefoonnummer }}</td>
                    <td class="border px-4 py-2">Baan {{ $res->baan_nummer }}</td>
                    <td class="border px-4 py-2">{{ $res->datum }}</td>
                    <td class="border px-4 py-2">{{ $res->tijd }}</td>
                    <td class="border px-4 py-2">{{ $res->aantal_personen }}</td>
                    <td class="border px-4 py-2">{{ $res->opmerking }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('reserveringen.edit', $res->id) }}" class="text-blue-600 hover:underline">Bewerk</a>
                        <form action="{{ route('reserveringen.destroy', $res->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Weet je zeker dat je deze reservering wilt verwijderen?')" class="text-red-600 hover:underline ml-2">Verwijder</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center text-gray-500 p-4">Geen reserveringen gevonden.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</x-app-layout>
