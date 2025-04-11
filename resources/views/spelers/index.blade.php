<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Overzicht Spelers</h1>

        @if (session('success'))
            <div class="mb-4 text-green-500">
                {{ session('success') }}
            </div>
        @endif

        <table class="table-auto w-full border border-gray-200 bg-white">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border">Naam</th>
                    <th class="py-2 px-4 border">Aantal Punten</th>
                    <th class="py-2 px-4 border">Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($uitslagen as $uitslag)
                <tr>
                    <td class="py-2 px-4 border">
                        {{ $uitslag->spel->reservering->persoon->voornaam }}
                        {{ $uitslag->spel->reservering->persoon->tussenvoegsel }}
                        {{ $uitslag->spel->reservering->persoon->achternaam }}
                    </td>
                    <td class="py-2 px-4 border">{{ $uitslag->aantal_punten }}</td>
                    <td class="py-2 px-4 border">
                        <a href="{{ route('spelers.edit', $uitslag->id) }}" 
                           class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">
                            Wijzigen
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
