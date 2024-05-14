@foreach($game->rounds as $round)
    <p>Ronde: {{ $round->current_round }}</p>
    <p>Voorraad: {{ $round->current_stock }}</p>
@endforeach
