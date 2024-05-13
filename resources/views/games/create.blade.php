<html>
    <form action="{{ route('games.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        {{-- Name --}}
        <label for="name">Game Naam</label>
        <input type="text" id="name" name="name">
        <br><br>
        {{-- Max Rounds --}}
        <label for="max_rounds">Max. Rondes</label>
        <input type="number" step="1" id="max_rounds" name="max_rounds">
        <br><br>
        {{-- Unit Fee --}}
        <label for="unit_fee">Unit Kosten</label>
        <input type="number" step="0.1" id="unit_fee" name="unit_fee">
        <br><br>
        {{-- Backlog Fee --}}
        <label for="backlog_fee">Backlog Kosten</label>
        <input type="number" step="0.1" id="backlog_fee" name="backlog_fee">
        <br><br>
        {{-- Delivery Time --}}
        <label for="delivery_time">Levertijd (in rondes)</label>
        <input type="number" step="1" id="delivery_time" name="delivery_time">
        <br><br>
        {{-- submit button --}}
        <div>
            <button type="submit">Maak Game</button>
        </div>

    </form>
</html>
