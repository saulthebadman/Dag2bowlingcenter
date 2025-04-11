<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Wijzig Uitslag</h1>

        <form method="POST" action="{{ route('spelers.update', $uitslag->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="aantal_punten" class="block text-sm font-medium text-gray-700">Aantal Punten</label>
                <input type="number" name="aantal_punten" id="aantal_punten" value="{{ old('aantal_punten', $uitslag->aantal_punten) }}"
                    class="border border-gray-300 rounded px-2 py-1 w-full">
                @error('aantal_punten')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Wijzigen</button>
                <a href="{{ route('spelers.index') }}" class="ml-4 text-gray-500 hover:underline">Annuleren</a>
            </div>
        </form>
    </div>
</x-app-layout>
