<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Uitslag Overzicht</h1>
        <table class="table-auto w-full border border-gray-200 bg-white">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border">Reservering ID</th>
                    <th class="py-2 px-4 border">Datum</th>
                    <th class="py-2 px-4 border">Aantal Uren</th>
                    <th class="py-2 px-4 border">Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reserveringen as $reservering)
                <tr>
                    <td class="py-2 px-4 border">{{ $reservering->id }}</td>
                    <td class="py-2 px-4 border">{{ $reservering->datum }}</td>
                    <td class="py-2 px-4 border">{{ $reservering->aantal_uren }}</td>
                    <td class="py-2 px-4 border">
                        <a href="#" class="text-blue-500 hover:underline">Bekijk</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-2 px-4 border text-center">Geen reserveringen gevonden.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>