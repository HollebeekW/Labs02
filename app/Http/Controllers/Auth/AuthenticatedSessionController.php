<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Game;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Game $game): View
    {
        return view('auth.login', ['game' => $game]);
    }
    public function createowner(Game $game): View
    {
        return view('auth.ownerlogin', ['game' => $game]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request, Game $game): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        return redirect(route('games.show', $game));
        //return redirect()->intended(route('dashboard', absolute: false));
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $game = $user->game;
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if($game){
            return redirect()->route('login', ['game' => $game]);
        }
        dd($user);
        return view('games.index');
        //return redirect("/games/{$game->slug}/login");
    }
}
