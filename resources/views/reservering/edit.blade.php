<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Details Optiepakket
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('reservering.update', $reservering->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="optiepakket_id" class="block text-sm font-medium text-gray-700">Optiepakket:</label>
                            <select id="optiepakket_id" name="optiepakket_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach ($pakketopties as $pakketoptie)
                                    <option value="{{ $pakketoptie->id }}" {{ $reservering->optiepakket_id == $pakketoptie->id ? 'selected' : '' }}>
                                        {{ $pakketoptie->naam }}
                                    </option>
                                @endforeach
                            </select>
                            @error('optiepakket_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Wijzigen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
