<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Wijzig Uitslag</h1>

        <form method="POST" action="{{ route('uitslagoverzicht.update', $uitslagOverzicht->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="spel_id" class="block text-sm font-medium text-gray-700">Spel</label>
                <select name="spel_id" id="spel_id" class="border border-gray-300 rounded px-2 py-1 w-full">
                    @foreach($spellen as $spel)
                        <option value="{{ $spel->id }}" {{ $spel->id == $uitslagOverzicht->spel_id ? 'selected' : '' }}>
                            Spel #{{ $spel->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="persoon_id" class="block text-sm font-medium text-gray-700">Persoon</label>
                <select name="persoon_id" id="persoon_id" class="border border-gray-300 rounded px-2 py-1 w-full">
                    @foreach($personen as $persoon)
                        <option value="{{ $persoon->id }}" {{ $persoon->id == $uitslagOverzicht->persoon_id ? 'selected' : '' }}>
                            {{ $persoon->voornaam }} {{ $persoon->tussenvoegsel }} {{ $persoon->achternaam }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="aantal_punten" class="block text-sm font-medium text-gray-700">Aantal Punten</label>
                <input type="number" name="aantal_punten" id="aantal_punten" value="{{ old('aantal_punten', $uitslagOverzicht->aantal_punten) }}"
                    class="border border-gray-300 rounded px-2 py-1 w-full" min="0" max="300" required>
                @error('aantal_punten')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Wijzigen</button>
                <a href="{{ route('uitslagoverzicht.index') }}" class="ml-4 text-gray-500 hover:underline">Annuleren</a>
            </div>
        </form>
    </div>
</x-app-layout>
