<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Wijzig Uitslag</h1>

        <form method="POST" action="{{ route('spelers.update', $uitslag->id) }}" id="editForm">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="aantal_punten" class="block text-sm font-medium text-gray-700">Aantal Punten</label>
                <input type="number" name="aantal_punten" id="aantal_punten" value="{{ old('aantal_punten', $uitslag->aantal_punten) }}"
                    class="border border-gray-300 rounded px-2 py-1 w-full"
                    min="0" max="300" required>
                <span id="errorMessage" class="text-red-500 text-sm hidden">Het aantal punten moet tussen 0 en 300 liggen.</span>
            </div>

            <div class="flex items-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Wijzigen</button>
                <a href="{{ route('spelers.index') }}" class="ml-4 text-gray-500 hover:underline">Annuleren</a>
            </div>
        </form>

        <script>
            document.getElementById('editForm').addEventListener('submit', function (e) {
                const punten = document.getElementById('aantal_punten').value;
                const errorMessage = document.getElementById('errorMessage');

                if (punten < 0 || punten > 300) {
                    e.preventDefault();
                    errorMessage.classList.remove('hidden');
                } else {
                    errorMessage.classList.add('hidden');
                }
            });
        </script>
    </div>
</x-app-layout>
