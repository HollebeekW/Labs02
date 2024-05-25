<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Game History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach($game->rounds as $round)
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <section class="space-y-6">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    Ronde: {{$round->current_round}}
                                </h2>


                            </header>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Total Cost: {{ $game->totalCostAtRound($round->current_round) }}
                            </p>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Week Cost: &euro;{{$round->total_cost}}
                            </p>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Stock: {{ $round->current_stock }}
                            </p>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Backlog: {{$round->backlog}}
                            </p>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Customer Order: {{$round->customer_orders}}
                            </p>
                        </section>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

</x-app-layout>
