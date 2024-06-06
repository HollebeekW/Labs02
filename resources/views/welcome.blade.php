<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('games.search')  }}">
        @csrf

        <!-- Game id and Button Container -->
        <div class="flex flex-col space-y-4">
            <!-- Game id -->
            <div>
                <x-input-label for="id" :value="__('Game ID')" />
                <x-text-input id="id" class="block mt-1 w-full"
                              type="number"
                              name="id"
                              :value="old('id')"
                              required autofocus autocomplete="id" />
                <x-input-error :messages="$errors->get('id')" class="mt-2" />
            </div>

            <!-- Button -->
            <div>
                <x-primary-button class="w-full">
                    {{ __('Enter') }}
                </x-primary-button>
            </div>

            <div class="flex items-center justify-between mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('games.index') }}">
                    {{ __('Show all games') }}
                </a>
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('games.create') }}">
                    {{ __('Create a game instead') }}
                </a>
            </div>
        </div>

    </form>
</x-guest-layout>
