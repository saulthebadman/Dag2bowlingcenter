<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Overzicht Uitslagen
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('reservering.toonUitslagen') }}">
                        @csrf
                        <div class="flex items-center space-x-4">
                            <div>
                                <label for="datum" class="block text-sm font-medium text-gray-700">Datum</label>
                                <input type="date" id="datum" name="datum" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @error('datum')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                    Tonen
                                </button>
                            </div>
                        </div>
                    </form>
                    @if (isset($uitslagen))
                        <table class="table-auto w-full border-collapse border border-gray-300 mt-6">
                            <thead>
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2">Naam</th>
                                    <th class="border border-gray-300 px-4 py-2">Aantal punten</th>
                                    <th class="border border-gray-300 px-4 py-2">Datum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($uitslagen as $uitslag)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">{{ $uitslag['naam'] }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $uitslag['punten'] }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $uitslag['datum'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
