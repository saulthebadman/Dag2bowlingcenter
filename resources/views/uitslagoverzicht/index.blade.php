<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Uitslag Overzicht</h1>

        <!-- Toon foutmeldingen -->
        @if (session('error'))
            <div class="mb-4 text-red-500">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter Form -->
        <form method="GET" action="{{ route('uitslagoverzicht.index') }}" class="mb-4">
            <div class="flex items-center">
                <input type="text" name="filter" value="{{ $filter }}" placeholder="Filter op naam"
                    class="border border-gray-300 rounded px-2 py-1 mr-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Filter</button>
            </div>
        </form>

        <table class="table-auto w-full border border-gray-200 bg-white">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border">Naam</th>
                    <th class="py-2 px-4 border">Datum</th>
                    <th class="py-2 px-4 border">Aantal Uren</th>
                    <th class="py-2 px-4 border">Begintijd</th>
                    <th class="py-2 px-4 border">Eindtijd</th>
                    <th class="py-2 px-4 border">Aantal Volwassenen</th>
                    <th class="py-2 px-4 border">Aantal Kinderen</th>
                    <th class="py-2 px-4 border">Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reserveringen as $reservering)
                <tr>
                    <td class="py-2 px-4 border">
                        {{ $reservering->persoon->voornaam }}
                        {{ $reservering->persoon->tussenvoegsel }}
                        {{ $reservering->persoon->achternaam }}
                    </td>
                    <td class="py-2 px-4 border">{{ $reservering->datum }}</td>
                    <td class="py-2 px-4 border">{{ $reservering->aantal_uren }}</td>
                    <td class="py-2 px-4 border">{{ $reservering->begintijd }}</td>
                    <td class="py-2 px-4 border">{{ $reservering->eindtijd }}</td>
                    <td class="py-2 px-4 border">{{ $reservering->aantal_volwassenen }}</td>
                    <td class="py-2 px-4 border">{{ $reservering->aantal_kinderen }}</td>
                    <td class="py-2 px-4 border">
                        <a href="{{ route('uitslagoverzicht.show', $reservering->id) }}" 
                           class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                            Bekijk Score
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-2 px-4 border text-center">Geen reserveringen gevonden.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>