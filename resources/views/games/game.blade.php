<!-- Only show round number if round is less than max rounds -->
@if($game->rounds->last()->current_round <= $game->max_rounds)
    <p>Ronde: {{ $game->rounds->last()->current_round }} / {{$game->max_rounds}}</p>
@endif


<p>Totale kosten: &euro;{{ $costResults }}</p>

<!-- Only show backlog if it exists -->
@if ($game->rounds->last()->backlog !== 0)
    <p>Huidige voorraad: 0</p>
    <p>Huidige backlog: {{ $game->rounds->last()->backlog }}</p>
@else
    <p>Huidige voorraad: {{ $game->rounds->last()->current_stock }}</p>
@endif

<!-- Only show next round button if current round is less than max rounds -->
@if ($game->rounds->last()->current_round <= $game->max_rounds)
<form action="{{ route('games.nextRound', $game->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <p>Verwachte verkopen: {{ $game->rounds->last()-> customer_orders}}</p>
    <p>Aantal inkopen:</p>
    <input type="number" id="stock" name="stock" min="0" value="0" step="1.0">

    <button type="submit">Verzenden (definitief)</button>
</form>

<!-- Only show delete and results buttons if max round has been reached -->
@else
    <a href="{{ route('games.destroy', $game->id) }}">Verwijder game en keer terug naar Index</a>
<br><br>
    <a href="{{ route('games.results', $game->id) }}">Resultaten</a>
@endif
<br><br>
<a href="{{ route('games.history', $game->id) }}">Geschiedenis</a>
