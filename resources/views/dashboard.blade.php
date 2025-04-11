<x-app-layout>
    <h2 class="text-xl font-semibold mb-4">Reserveringen</h2>

    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="p-3">ID</th>
                <th class="p-3">Gebruiker</th>
                <th class="p-3">Datum & Tijd</th>
                <th class="p-3">Acties</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reserveringen as $res)
                <tr class="border-t">
                    <td class="p-3">{{ $res->id }}</td>
                    <td class="p-3">{{ $res->user->name ?? 'Onbekend' }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($res->tijd)->format('d-m-Y H:i') }}</td>
                    <td class="p-3">
                        <a href="{{ route('reserveringen.edit', $res) }}" class="text-blue-500 underline">Bewerken</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-3 text-center text-gray-500">Geen reserveringen gevonden.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-app-layout>
