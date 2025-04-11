<x-app-layout>
    <h1>Reservering bewerken</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('reserveringen.update', $reservering) }}">
        @csrf
        @method('PUT')

        <label for="tijd">Tijd:</label>
        <input type="datetime-local" name="tijd" value="{{ old('tijd', $reservering->tijd->format('Y-m-d\TH:i')) }}">
        @error('tijd') <p>{{ $message }}</p> @enderror

        <label for="aantal_personen">Aantal personen:</label>
        <input type="number" name="aantal_personen" value="{{ old('aantal_personen', $reservering->aantal_personen) }}">
        @error('aantal_personen') <p>{{ $message }}</p> @enderror

        <button type="submit">Opslaan</button>
    </form>
</x-app-layout>
