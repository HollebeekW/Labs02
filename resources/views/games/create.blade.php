<html>
    <a href="{{ route('games.index') }}">Terug naar Index</a>
    <br>
    <br>
    <form action="{{ route('games.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        {{-- Name --}}
        <label for="name">Game Naam</label>
        <input type="text" id="name" name="name">
        <br><br>
        {{-- Max Rounds --}}
        <label for="max_rounds">Max. Rondes</label>
        <input type="number" step="1" id="max_rounds" name="max_rounds" max="10">
        <br><br>
        {{-- Unit Fee --}}
        <label for="unit_fee">Unit Kosten</label>
        <input type="number" step="0.1" id="unit_fee" name="unit_fee" max="2" value="0.50">
        <br><br>
        {{-- Backlog Fee --}}
        <label for="backlog_fee">Backlog Kosten</label>
        <input type="number" step="0.1" id="backlog_fee" name="backlog_fee" max="2" value="1">
        <br><br>
        {{-- submit button --}}
        <div>
            <button type="submit">Maak Game</button>
        </div>

    </form>
</html>
