@foreach($game->rounds as $round)
    <p>Ronde: {{ $round->current_round }}</p>
    <p>Items besteld: {{ $round->ordered_stock }}</p>
    <p>Voorraad: {{ $round->current_stock }}</p>
    <p>Backlog: {{$round->backlog}}</p>
    <p>Verkochte items: {{$round->customer_orders}}</p>
    <p>Kosten: &euro;{{$round->total_cost}}</p>
    <br>
@endforeach
