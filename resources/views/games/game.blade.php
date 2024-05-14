<p>{{ $game->rounds->last()->current_round }}</p>

<a href="{{ route('games.nextRound', $game->id) }}">Volgende Ronde</a>
