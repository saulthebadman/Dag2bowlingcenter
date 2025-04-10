<x-app-layout>
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Nieuwe Reservering</h1>

    @if($errors->has('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            {{ $errors->first('error') }}
        </div>
    @endif

    <form action="{{ route('reserveringen.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="klant_naam" class="block font-medium">Klantnaam</label>
            <input type="text" name="klant_naam" value="{{ old('klant_naam') }}" class="w-full border rounded px-3 py-2 @error('klant_naam') border-red-500 @enderror">
            @error('klant_naam')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="telefoonnummer" class="block font-medium">Telefoonnummer</label>
            <input type="text" name="telefoonnummer" value="{{ old('telefoonnummer') }}" class="w-full border rounded px-3 py-2 @error('telefoonnummer') border-red-500 @enderror">
            @error('telefoonnummer')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="datum" class="block font-medium">Datum</label>
                <input type="date" name="datum" value="{{ old('datum') }}" class="w-full border rounded px-3 py-2 @error('datum') border-red-500 @enderror">
                @error('datum')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tijd" class="block font-medium">Tijd</label>
                <input type="time" name="tijd" value="{{ old('tijd') }}" class="w-full border rounded px-3 py-2 @error('tijd') border-red-500 @enderror">
                @error('tijd')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="aantal_personen" class="block font-medium">Aantal Personen</label>
            <input type="number" name="aantal_personen" value="{{ old('aantal_personen') }}" class="w-full border rounded px-3 py-2 @error('aantal_personen') border-red-500 @enderror">
            @error('aantal_personen')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="opmerking" class="block font-medium">Opmerking</label>
            <textarea name="opmerking" class="w-full border rounded px-3 py-2 @error('opmerking') border-red-500 @enderror">{{ old('opmerking') }}</textarea>
            @error('opmerking')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="opties" class="block font-medium">Opties</label>
            <select name="opties[]" multiple class="w-full border rounded px-3 py-2">
                <option value="Snackpakket Basis">Snackpakket Basis</option>
                <option value="Snackpakket Luxe">Snackpakket Luxe</option>
                <option value="Kinderpartij">Kinderpartij</option>
                <option value="Vrijgezellenfeest">Vrijgezellenfeest</option>
            </select>
        </div>

        <div>
            <label for="betaling_op_locatie" class="block font-medium">Betaling op locatie</label>
            <input type="checkbox" name="betaling_op_locatie" value="1" {{ old('betaling_op_locatie') ? 'checked' : '' }} class="rounded">
        </div>

        <div>
            <label for="totaalbedrag" class="block font-medium">Totaalbedrag</label>
            <input type="text" id="totaalbedrag" readonly class="w-full border rounded px-3 py-2 bg-gray-100">
        </div>

        <div>
            <label for="magic_bowlen" class="block font-medium">Magic Bowlen</label>
            <input type="checkbox" id="magic_bowlen" disabled class="rounded bg-gray-100">
            <p class="text-sm text-gray-500">Magic Bowlen is beschikbaar in het weekend van 22:00 tot 24:00 uur.</p>
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('reserveringen.index') }}" class="text-gray-600 underline">Annuleren</a>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Opslaan</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const datumInput = document.querySelector('input[name="datum"]');
        const tijdInput = document.querySelector('input[name="tijd"]');
        const aantalPersonenInput = document.querySelector('input[name="aantal_personen"]');
        const totaalbedragInput = document.getElementById('totaalbedrag');
        const magicBowlenCheckbox = document.getElementById('magic_bowlen');

        function berekenTarief() {
            const datum = datumInput.value;
            const tijd = tijdInput.value;
            const aantalPersonen = parseInt(aantalPersonenInput.value) || 0;

            if (!datum || !tijd || aantalPersonen <= 0) {
                totaalbedragInput.value = 'Vul alle velden in';
                magicBowlenCheckbox.checked = false;
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
                } else if (uur >= 18 && uur < 22) {
                    tariefPerUur = 33.50; // Vrijdag t/m zondag 18:00 - 22:00
                } else if (uur >= 22 && uur <= 24) {
                    tariefPerUur = 33.50; // Magic Bowlen
                    magicBowlenCheckbox.checked = true;
                } else {
                    magicBowlenCheckbox.checked = false;
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
