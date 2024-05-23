<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Game') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Update Game Details') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Edit the details of your game.") }}
                            </p>
                        </header>

                        <form method="POST" action="{{ route('games.update', $game) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PUT')
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required
                                              :value="old('name', $game->name)"/>
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="current_round" :value="__('Current Round')" />
                                <x-text-input id="current_round" name="current_round" type="number" class="mt-1 block w-full"  required
                                              :value="old('current_round', $game->current_round)"/>
                                <x-input-error :messages="$errors->get('current_round')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="max_round" :value="__('Maximum Rounds')" />
                                <x-text-input id="max_round" name="max_round" type="number" class="mt-1 block w-full"  required
                                              :value="old('max_round', $game->max_round)"/>
                                <x-input-error :messages="$errors->get('max_round')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="unit_fee" :value="__('Unit Fee')" />
                                <x-text-input id="unit_fee" name="unit_fee" type="text" class="mt-1 block w-full" required
                                              pattern="[0-9]+(\.[0-9]+)?"
                                              :value="old('unit_fee', $game->unit_fee)"/>
                                <x-input-error :messages="$errors->get('unit_fee')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="backlog_fee" :value="__('Backlog Fee')" />
                                <x-text-input id="backlog_fee" name="backlog_fee" type="text" class="mt-1 block w-full" required
                                              pattern="[0-9]+(\.[0-9]+)?"
                                              :value="old('backlog_fee', $game->backlog_fee)"/>
                                <x-input-error :messages="$errors->get('backlog_fee')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="delivery_time" :value="__('Delivery Time')" />
                                <x-text-input id="delivery_time" name="delivery_time" type="text" class="mt-1 block w-full" required
                                              :value="old('delivery_time', $game->delivery_time)"/>
                                <x-input-error :messages="$errors->get('delivery_time')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Update') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
