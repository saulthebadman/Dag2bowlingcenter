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

        @if ($errors->has('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ $errors->first('error') }}
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

            <div>
                <label class="block font-medium text-gray-700">Opties</label>
                <select name="opties[]" multiple class="w-full border rounded px-3 py-2">
                    <option value="Snackpakket Basis" {{ in_array('Snackpakket Basis', json_decode($reservering->opties, true) ?? []) ? 'selected' : '' }}>Snackpakket Basis</option>
                    <option value="Snackpakket Luxe" {{ in_array('Snackpakket Luxe', json_decode($reservering->opties, true) ?? []) ? 'selected' : '' }}>Snackpakket Luxe</option>
                    <option value="Kinderpartij" {{ in_array('Kinderpartij', json_decode($reservering->opties, true) ?? []) ? 'selected' : '' }}>Kinderpartij</option>
                    <option value="Vrijgezellenfeest" {{ in_array('Vrijgezellenfeest', json_decode($reservering->opties, true) ?? []) ? 'selected' : '' }}>Vrijgezellenfeest</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Betaling op locatie</label>
                <input type="checkbox" name="betaling_op_locatie" value="1" {{ $reservering->betaling_op_locatie ? 'checked' : '' }} class="rounded">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Totaalbedrag</label>
                <input type="text" id="totaalbedrag" readonly class="w-full border rounded px-3 py-2 bg-gray-100" value="€ {{ number_format($reservering->tarief, 2) }}">
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('reserveringen.index') }}" class="text-gray-600 hover:underline">Annuleren</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    Wijzigingen Opslaan
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const datumInput = document.querySelector('input[name="datum"]');
            const tijdInput = document.querySelector('input[name="tijd"]');
            const aantalPersonenInput = document.querySelector('input[name="aantal_personen"]');
            const totaalbedragInput = document.getElementById('totaalbedrag');

            function berekenTarief() {
                const datum = datumInput.value;
                const tijd = tijdInput.value;
                const aantalPersonen = parseInt(aantalPersonenInput.value) || 0;

                if (!datum || !tijd || aantalPersonen <= 0) {
                    totaalbedragInput.value = 'Vul alle velden in';
                    return;
                }

                const dag = new Date(datum).getDay(); // 0 = zondag, 6 = zaterdag
                const uur = parseInt(tijd.split(':')[0]);

                let tariefPerUur = 0;

                if (dag >= 1 && dag <= 4) {
                    tariefPerUur = 24.00; // Maandag t/m donderdag
                } else if (dag === 5 || dag === 6 || dag === 0) {
                    if (uur >= 14 && uur < 18) {
                        tariefPerUur = 28.00; // Vrijdag t/m zondag 14:00 - 18:00
                    } else if (uur >= 18 && uur <= 24) {
                        tariefPerUur = 33.50; // Vrijdag t/m zondag 18:00 - 24:00
                    }
                }

                const totaalbedrag = tariefPerUur * aantalPersonen;
                totaalbedragInput.value = `€ ${totaalbedrag.toFixed(2)}`;
            }

            datumInput.addEventListener('change', berekenTarief);
            tijdInput.addEventListener('change', berekenTarief);
            aantalPersonenInput.addEventListener('input', berekenTarief);
        });
    </script>
</x-app-layout>
