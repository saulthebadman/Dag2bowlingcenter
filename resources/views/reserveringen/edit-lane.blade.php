<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Details Baannummer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('reserveringen.update-lane', $reservering) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label for="baannummer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Baannummer:</label>
                            <select id="baannummer" name="baannummer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="1" {{ $reservering->baannummer == 1 ? 'selected' : '' }}>1 (Geen hekjes)</option>
                                <option value="2" {{ $reservering->baannummer == 2 ? 'selected' : '' }}>2 (Met hekjes)</option>
                                <option value="3" {{ $reservering->baannummer == 3 ? 'selected' : '' }}>3 (Met hekjes)</option>
                                <option value="4" {{ $reservering->baannummer == 4 ? 'selected' : '' }}>4 (Geen hekjes)</option>
                                <option value="7" {{ $reservering->baannummer == 7 ? 'selected' : '' }}>7 (Geen hekjes)</option>
                                <option value="8" {{ $reservering->baannummer == 8 ? 'selected' : '' }}>8 (Geen hekjes)</option>
                            </select>
                            @error('baannummer')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Wijzigen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
