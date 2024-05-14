<a href="{{ route('games.index') }}">Terug naar Index</a>

<h1>{{ $game->name }}</h1>

<p>Max. Rondes: {{$game->max_rounds}}</p>
<p>Unit Kosten: {{ $game->unit_fee }}</p>
<p>Backlog Kosten: {{ $game->backlog_fee }}</p>
<p>Levertijd: {{ $game->delivery_time }}</p>

<a href="{{ route('games.edit', $game->id) }}">Bewerk Game</a>
<br>
<a href="#">Start Game</a>
