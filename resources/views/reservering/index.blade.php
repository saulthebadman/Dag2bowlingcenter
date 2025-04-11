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
                    @if (session('success'))
                        <div class="mb-4 text-green-500">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 text-red-500">
                            {{ session('error') }}
                        </div>
                    @endif
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Reserveringen Overzicht') }}
                    </h2>
                    <table class="table-auto w-full border-collapse border border-gray-300 mt-4">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">Naam</th>
                                <th class="border border-gray-300 px-4 py-2">Datum</th>
                                <th class="border border-gray-300 px-4 py-2">Volwassenen</th>
                                <th class="border border-gray-300 px-4 py-2">Kinderen</th>
                                <th class="border border-gray-300 px-4 py-2">Optiepakket</th>
                                <th class="border border-gray-300 px-4 py-2">Wijzigen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reserveringen as $reservering)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $reservering->naam }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $reservering->datum }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $reservering->aantal_volwassenen }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $reservering->aantal_kinderen }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $reservering->optiepakket }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('reservering.edit', $reservering->id) }}" class="text-blue-500">
                                            Wijzigen
                                        </a>
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

