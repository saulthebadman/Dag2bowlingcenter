<x-app-layout>
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Uitslag Overzicht</h1>
    <table class="table-auto w-full border border-gray-200 bg-white">
        <thead>
            <tr class="bg-gray-100">
                <th class="py-2 px-4 border">Persoon</th>
                <th class="py-2 px-4 border">Spel</th>
                <th class="py-2 px-4 border">Aantal Punten</th>
                <th class="py-2 px-4 border">Acties</th>
            </tr>
        </thead>
        <tbody>
            @forelse($uitslagen as $uitslag)
            <tr>
                <td class="py-2 px-4 border">{{ $uitslag->persoon->naam }}</td>
                <td class="py-2 px-4 border">{{ $uitslag->spel->naam }}</td>
                <td class="py-2 px-4 border">{{ $uitslag->aantal_punten }}</td>
                <td class="py-2 px-4 border">
                    <a href="{{ route('uitslagoverzicht.edit', $uitslag) }}" class="text-blue-500 hover:underline">Bewerken</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-2 px-4 border text-center">Geen gegevens gevonden.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
</x-app-layout>