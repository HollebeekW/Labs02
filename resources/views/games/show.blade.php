<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $game->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    @if($game->finished)
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Final results
                        </p>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Total Cost: {{ $game->totalCost('wholesaler') }}
                        </p>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('games.history', $game) }}">
                                {{ __('Show history') }}
                            </a>
                        </p>
                    @else
                        <div class="grid grid-cols-2 gap-4">
                            <!-- First line -->
                            <div class="bg-gray-200 dark:bg-gray-900 p-4 rounded">
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Retailer Order: {{ $game->previousOrder()->retailer_order }}
                                </p>
                            </div>
                            <div class="bg-gray-200 dark:bg-gray-900 p-4 rounded">
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Outgoing delivery: {{ $game->currentRound()->wholesaler_send }}
                                </p>
                            </div>

                            <!-- Second line -->
                            <div class="bg-gray-200 dark:bg-gray-900 p-4 rounded">
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Total Cost: &euro;{{ $game->totalCost('wholesaler') }}
                                </p>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Week Cost: &euro;{{ $game->currentRound()->cost('wholesaler') }}
                                </p>
                            </div>
                            <div class="bg-gray-200 dark:bg-gray-900 p-4 rounded">
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Stock: {{ $game->currentRound()->wholesaler_stock }}
                                </p>
                                @if($game->currentRound()->wholesaler_backlog > 0)
                                    <p class="mt-1 text-sm text-red-600 dark:text-gray-400">
                                        Backlog: {{ $game->currentRound()->wholesaler_backlog }}
                                    </p>
                                @endif
                            </div>

                            <!-- Third line -->
                            <div class="bg-gray-200 dark:bg-gray-900 p-4 rounded">
                                <!-- Order amount Form-->
                                <form method="POST" action="{{ route('user_orders.store', $game->slug) }}" class="mt-4">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="order_amount" class="block text-gray-700 dark:text-gray-400">Order Amount</label>
                                        <input type="number" id="order_amount" name="order_amount" required class="mt-1 block w-full dark:bg-gray-700 dark:bg-gray-200">
                                        @error('order_amount')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <x-primary-button class="ms-3">
                                        {{ __('Submit Order') }}
                                    </x-primary-button>
                                </form>
                            </div>
                            <div class="bg-gray-200 dark:bg-gray-900 p-4 rounded">
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    @if($game->deliveredRound())
                                        Incoming delivery: {{ $game->deliveredRound()->distributor_send}}
                                    @else
                                        Incoming delivery: 400 (not found)
                                    @endif
                                </p>
                            </div>
                        </div>


                        <!-- Full width -->
                        <div class="mt-4 bg-gray-200 dark:bg-gray-900 p-4 rounded">
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Max Round: {{ $game->max_round }}
                            </p>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Current Round: {{ $game->current_round }}
                            </p>
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>


