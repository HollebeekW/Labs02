<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Games List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                    </section>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border-b border-gray-200  dark:border-gray-700">
                    <a href="{{ route('games.create') }}">Add New Game</a>
                    <ul>
                        @foreach ($games as $game)
                            <li>{{ $game->name }} -
                                <a href="{{ route('games.show', $game->slug) }}">View</a> -
                                <a href="{{ route('games.edit', $game->slug) }}">Edit</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
