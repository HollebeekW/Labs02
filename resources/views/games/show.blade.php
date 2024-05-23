<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $game->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Current Round: {{ $game->current_round }}
                    </p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Max Round: {{ $game->max_round }}
                    </p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Stock: {{ $game->latestRound()->current_stock }}
                    </p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Backlog: {{$game->latestRound()->backlog}}
                    </p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Customer Order: {{$game->latestRound()->customer_orders}}
                    </p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Kosten: &euro;{{$game->latestRound()->total_cost}}
                    </p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Incoming delivery: {{$game->deliveredGameOrder()->order_amount}}
                    </p>

                    <!-- Order amount Form-->
                    <form method="POST" action="{{ route('user_orders.store', $game->slug) }}" class="mt-4">
                        @csrf
                        <div class="mb-4">
                            <label for="order_amount" class="block text-gray-700 dark:text-gray-400">Order Amount</label>
                            <input type="number" id="order_amount" name="order_amount" required class="mt-1 block w-full">
                            @error('order_amount')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <x-primary-button class="ms-3">
                            {{ __('Submit Order') }}
                        </x-primary-button>
{{--                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Order</button>--}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


