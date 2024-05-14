@foreach($game->rounds as $round)
    <p>Ronde: {{ $round->current_round }}</p>
    <p>Voorraad: {{ $round->current_stock }}</p>
    <p>Verkochte items: {{$round->customer_orders}}</p>
    <br>
@endforeach
