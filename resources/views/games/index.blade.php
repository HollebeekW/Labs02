<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Games List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700">
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($games as $game)
                            <li class="py-4 flex justify-between items-center">
                                <span class="text-lg text-gray-700 dark:text-gray-300">{{ $game->name }}</span>
                                <div>
                                    <a href="{{ route('games.show', $game->slug) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline mr-4">
                                        View
                                    </a>
                                    <a href="{{ route('games.edit', $game->slug) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                        Edit
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

                <div class="max-w-xl">
                    <section>
                        <x-primary-button>
                            <a href="{{ route('games.create') }}">Create a game</a>
                        </x-primary-button>

                    </section>
                </div>

        </div>
    </div>
</x-app-layout>
