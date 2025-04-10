<x-app-layout>
    <div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-lg mt-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Bewerk Reservering</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                <strong>Er zijn fouten opgetreden:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reserveringen.update', $reservering->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <input type="hidden" name="klant_id" value="{{ $reservering->klant_id }}">

            <div>
                <label class="block font-medium text-gray-700">Klantnaam</label>
                <input type="text" name="klant_naam" class="w-full border rounded px-4 py-2" value="{{ old('klant_naam', $reservering->klant_naam) }}">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Telefoonnummer</label>
                <input type="text" name="telefoonnummer" class="w-full border rounded px-4 py-2" value="{{ old('telefoonnummer', $reservering->telefoonnummer) }}">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-gray-700">Datum</label>
                    <input type="date" name="datum" class="w-full border rounded px-4 py-2" value="{{ old('datum', $reservering->datum) }}">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Tijd</label>
                    <input type="time" name="tijd" class="w-full border rounded px-4 py-2" value="{{ old('tijd', $reservering->tijd) }}">
                </div>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Aantal Personen</label>
                <input type="number" name="aantal_personen" class="w-full border rounded px-4 py-2" value="{{ old('aantal_personen', $reservering->aantal_personen) }}">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Opmerking</label>
                <textarea name="opmerking" rows="3" class="w-full border rounded px-4 py-2">{{ old('opmerking', $reservering->opmerking) }}</textarea>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('reserveringen.index') }}" class="text-gray-600 hover:underline">Annuleren</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    Wijzigingen Opslaan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
