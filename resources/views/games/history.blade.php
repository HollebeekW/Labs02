<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Game History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach($game->rounds as $round)
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <section class="space-y-6">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    Ronde: {{$round->current_round}}
                                </h2>


                            </header>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Total Cost: {{ $round->totalCost() }}
                            </p>


                            @if($round->wholesaler_backlog == 0)
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Wholesaler Stock: {{ $round->wholesaler_stock }}
                                </p>
                            @else
                                <p class="mt-1 text-sm text-red-600 dark:text-gray-400">
                                    Wholesaler Backlog: {{ $round->wholesaler_backlog }}
                                </p>
                            @endif

                            @if($game->finished)
                                @if($round->retailer_backlog == 0)
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        Retailer Stock: {{ $round->retailer_stock }}
                                    </p>
                                @else
                                    <p class="mt-1 text-sm text-red-600 dark:text-gray-400">
                                        Retailer Backlog: {{ $round->retailer_backlog }}
                                    </p>
                                @endif

                                @if($round->distributor_backlog == 0)
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        Distributor Stock: {{ $round->distributor_stock }}
                                    </p>
                                @else
                                    <p class="mt-1 text-sm text-red-600 dark:text-gray-400">
                                        Distributor Backlog: {{ $round->distributor_backlog }}
                                    </p>
                                @endif

                                @if($round->manufacturer_backlog == 0)
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        Manufacturer Stock: {{ $round->manufacturer_stock }}
                                    </p>
                                @else
                                    <p class="mt-1 text-sm text-red-600 dark:text-gray-400">
                                        Manufacturer Backlog: {{ $round->manufacturer_backlog }}
                                    </p>
                                @endif
                            @endif
                        </section>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

</x-app-layout>
