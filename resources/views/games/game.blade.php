<p>Huidige Ronde: {{ $game->rounds->last()->current_round }}</p>
<p>Huidige voorraad: {{ $game->rounds->last()->current_stock }}</p>

@if ($game->rounds->last()->current_round < $game->max_rounds)
<form action="{{ route('games.nextRound', $game->id) }}" method="post">
    @csrf
    <p>Aantal inkopen:</p>
    <input type="number" id="stock" name="stock" min="1">

    <button type="submit">Verzenden (definitief)</button>
</form>

@else
    <a href="{{ route('games.destroy', $game->id) }}">Verwijder game en keer terug naar Index</a>
@endif
<br><br>
<a href="{{ route('games.results', $game->id) }}">Geschiedenis</a>