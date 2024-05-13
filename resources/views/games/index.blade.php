@if ($games != null && $games->count() > 0)
    <table>
        <thead>
        <tr>
            <th>Naam</th>
            <th>Rondes</th>

        </tr>
        </thead>
        <tbody>
        @foreach($games as $game)
            <tr>
                <td>{{ $game->name }}</td>
                <td>{{ $game->max_rounds }}</td>
                <td><a href="{{ route('games.show', $game->id) }}">Details</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>Geen Games Gevonden</p>
@endif
<br><br>
<a href="{{ route('games.create') }}">Maak Game</a>
