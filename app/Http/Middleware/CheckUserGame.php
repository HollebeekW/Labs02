<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;

class CheckUserGame
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $game = $request->route('game');

        if(!$user || !$game || $user->game_id !== $game->id) {
            // Log out the user and redirect to the game's login page
            Auth::logout();
            return redirect()->route('login', ['game' => $game]);
        }
        return $next($request);
    }
}
