<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Beschikbare Banen</h1>

        <form action="{{ route('banen.index') }}" method="GET" class="space-y-4">
            <div>
                <label for="datum" class="block font-medium">Datum</label>
                <input type="date" name="datum" value="{{ request('datum') }}" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label for="tijd" class="block font-medium">Tijd</label>
                <input type="time" name="tijd" value="{{ request('tijd') }}" class="w-full border rounded px-3 py-2">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Zoeken</button>
        </form>

        @if(isset($banen))
            <h2 class="text-xl font-bold mt-6">Beschikbare Banen</h2>
            <ul class="mt-4">
                @foreach($banen as $baan)
                    <li>Baan {{ $baan->nummer }} - {{ $baan->status }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
