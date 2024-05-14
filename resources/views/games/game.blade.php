<p>Huidige Ronde: {{ $game->rounds->last()->current_round }}</p>

@if ($game->rounds->last()->backlog !== 0)
    <p>Huidige voorraad: 0</p>
    <p>Huidige backlog: {{ $game->rounds->last()->backlog }}</p>
@else
    <p>Huidige voorraad: {{ $game->rounds->last()->current_stock }}</p>
@endif

@if ($game->rounds->last()->current_round < $game->max_rounds)
<form action="{{ route('games.nextRound', $game->id) }}" method="post">
    @csrf
    <p>Verwachte verkopen: {{ $game->rounds->last()-> customer_orders}}</p>
    <p>Aantal inkopen:</p>
    <input type="number" id="stock" name="stock" min="0">

    <button type="submit">Verzenden (definitief)</button>
</form>

@else
    <a href="{{ route('games.destroy', $game->id) }}">Verwijder game en keer terug naar Index</a>
@endif
<br><br>
<a href="{{ route('games.results', $game->id) }}">Geschiedenis</a>
