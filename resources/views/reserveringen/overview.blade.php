<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Overzicht Reserveringen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="GET" action="{{ route('reserveringen.overview') }}" class="mb-4 flex items-center">
                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mr-4">Datum:</label>
                        <input type="date" id="date" name="date" value="{{ $date }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <button type="submit" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded">Tonen</button>
                    </form>

                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2">Naam</th>
                                <th class="border px-4 py-2">Reserveringsdatum</th>
                                <th class="border px-4 py-2">Uren</th>
                                <th class="border px-4 py-2">Volwassen</th>
                                <th class="border px-4 py-2">Kinderen</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reserveringen as $reservering)
                                <tr>
                                    <td class="border px-4 py-2">{{ $reservering->user->name }}</td>
                                    <td class="border px-4 py-2">{{ $reservering->reserveringsdatum->format('d-m-Y') }}</td>
                                    <td class="border px-4 py-2">{{ $reservering->uren }}</td>
                                    <td class="border px-4 py-2">{{ $reservering->volwassen }}</td>
                                    <td class="border px-4 py-2">{{ $reservering->kinderen }}</td>
                                    <td class="border px-4 py-2">{{ $reservering->status }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('reserveringen.edit-lane', $reservering) }}" class="text-blue-500 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M17.414 2.586a2 2 0 010 2.828l-10 10a2 2 0 01-.878.516l-4 1a1 1 0 01-1.264-1.264l1-4a2 2 0 01.516-.878l10-10a2 2 0 012.828 0zM15.586 4L12 7.586 14.414 10 18 6.414 15.586 4zM11 8.586L4.414 15H7v2.586L13.586 11 11 8.586z" />
                                            </svg>
                                            Wijzigen
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="border px-4 py-2 text-center text-red-500">
                                        Er is geen reserveringsinformatie beschikbaar voor deze geselecteerde datum.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
