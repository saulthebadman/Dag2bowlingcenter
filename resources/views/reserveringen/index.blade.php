<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reserveringen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Gebruiker</th>
                                <th class="px-4 py-2">Datum</th>
                                <th class="px-4 py-2">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reserveringen as $reservering)
                                <tr>
                                    <td class="border px-4 py-2">{{ $reservering->id }}</td>
                                    <td class="border px-4 py-2">{{ $reservering->user->name ?? 'Onbekend' }}</td>
                                    <td class="border px-4 py-2">{{ $reservering->created_at->format('d-m-Y') }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('reserveringen.edit', $reservering) }}" class="text-blue-500">Bewerken</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border px-4 py-2 text-center">Geen reserveringen gevonden.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
