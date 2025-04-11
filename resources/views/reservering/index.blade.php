<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reserveringsoverzicht
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Reserveringen Overzicht') }}
                    </h2>
                    <table class="table-auto w-full border-collapse border border-gray-300 mt-4">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">Naam</th>
                                <th class="border border-gray-300 px-4 py-2">Datum</th>
                                <th class="border border-gray-300 px-4 py-2">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reserveringen as $reservering)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $reservering->naam }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $reservering->datum }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('reservering.edit', $reservering->id) }}" class="text-blue-500">Bewerken</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </x-app-layout>

