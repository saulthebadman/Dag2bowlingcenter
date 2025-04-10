<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Reserveringen</h1>

        @if(session('success'))
            <script>alert("{{ session('success') }}");</script>
        @endif

        @if(session('error'))
            <script>alert("{{ session('error') }}");</script>
        @endif

        <form method="GET" action="{{ route('reserveringen.index') }}" class="mb-6 flex items-center gap-2">
            <input type="text" name="zoek" placeholder="Zoek op klantnaam..." value="{{ $zoekterm }}" 
                   class="border border-gray-300 rounded px-4 py-2 w-1/3 focus:ring focus:border-blue-400">
            <button type="submit" 
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Zoeken</button>
        </form>

        <div class="flex justify-end mb-4">
            <a href="{{ route('reserveringen.create') }}" 
               class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">+ Nieuwe Reservering</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 shadow-sm rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-3 text-left">Reservering Nr</th>
                        <th class="border px-4 py-3 text-left">Klant</th>
                        <th class="border px-4 py-3 text-left">Telefoon</th>
                        <th class="border px-4 py-3 text-left">Datum</th>
                        <th class="border px-4 py-3 text-left">Tijd</th>
                        <th class="border px-4 py-3 text-left">Aantal Personen</th>
                        <th class="border px-4 py-3 text-left">Acties</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    @forelse($reserveringen as $reservering)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="border px-4 py-2">{{ $reservering->reserveringsnummer }}</td>
                            <td class="border px-4 py-2">{{ $reservering->klant_naam }}</td>
                            <td class="border px-4 py-2">{{ $reservering->telefoonnummer }}</td>
                            <td class="border px-4 py-2">{{ $reservering->datum }}</td>
                            <td class="border px-4 py-2">{{ $reservering->tijd }}</td>
                            <td class="border px-4 py-2">{{ $reservering->aantal_personen }}</td>
                            <td class="border px-4 py-2 flex gap-2">
                                <a href="{{ route('reserveringen.edit', $reservering->id) }}"
                                   class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition text-sm">Bewerk</a>
                                
                                <form action="{{ route('reserveringen.destroy', $reservering->id) }}" method="POST"
                                      onsubmit="return confirm('Weet je zeker dat je deze reservering wilt verwijderen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition text-sm">Verwijder</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-500">Geen reserveringen gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
