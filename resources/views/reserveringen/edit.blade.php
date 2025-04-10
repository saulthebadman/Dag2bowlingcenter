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

            <div>
                <label class="block font-medium text-gray-700">Klantnaam</label>
                <input type="text" name="klant_naam" class="w-full border rounded px-4 py-2" value="{{ old('klant_naam', $reservering->klant_naam) }}">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Telefoonnummer</label>
                <input type="text" name="telefoonnummer" class="w-full border rounded px-4 py-2" value="{{ old('telefoonnummer', $reservering->telefoonnummer) }}">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Baan</label>
                <select name="baan_id" class="w-full border rounded px-4 py-2">
                    <option value="">-- Kies een baan --</option>
                    @foreach($banen as $baan)
                        <option value="{{ $baan->id }}" {{ $baan->id == $reservering->baan_id ? 'selected' : '' }}>
                            {{ $baan->nummer }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-gray-700">Datum</label>
                    <input type="date
