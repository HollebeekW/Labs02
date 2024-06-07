<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Game') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Game Details') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Fill in the following details to create a new game.") }}
                            </p>
                        </header>

                        <form method="POST" action="{{ route('games.store') }}" class="mt-6 space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="max_round" :value="__('Maximum Rounds')" />
                                <x-text-input id="max_round" name="max_round" type="number" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('max_round')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="delivery_time" :value="__('Delivery Time')" />
                                <x-text-input id="delivery_time" name="delivery_time" type="number" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('delivery_time')" class="mt-2" />
                            </div>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Create an owner account.") }}
                            </p>

                            <div>
                                <x-input-label for="owner_name" :value="__('Owner Name')" />
                                <x-text-input id="owner_name" name="owner_name" type="text" class="block mt-1 w-full" required />
                                <x-input-error :messages="$errors->get('ownername')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" name="password" type="password" class="block mt-1 w-full" required />
                                <small>Minimum length of 8 characters</small>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block mt-1 w-full" required />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
