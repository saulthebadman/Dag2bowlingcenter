<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Uitslagen voor Reservering #{{ $reservering->id }}</h1>
        <p class="mb-4">
            Reservering van: {{ $reservering->persoon->voornaam }} {{ $reservering->persoon->tussenvoegsel }} {{ $reservering->persoon->achternaam }}<br>
            Datum: {{ $reservering->datum }}<br>
            Tijd: {{ $reservering->begintijd }} - {{ $reservering->eindtijd }}
        </p>

        <table class="table-auto w-full border border-gray-200 bg-white">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border">Spel ID</th>
                    <th class="py-2 px-4 border">Aantal Punten</th>
                </tr>
            </thead>
            <tbody>
                @foreach($uitslagen as $uitslag)
                <tr>
                    <td class="py-2 px-4 border">{{ $uitslag->spel_id }}</td>
                    <td class="py-2 px-4 border">{{ $uitslag->aantal_punten }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <a href="{{ route('uitslagoverzicht.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Terug naar Overzicht</a>
        </div>
    </div>
</x-app-layout>
