<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function shuffle()
    {
        $response = Http::get('https://higherorlower-api.netlify.app/json');
        $cards = collect($response->json())->shuffle()->map(function ($card) {
            return [
                'value' => $this->transformCardValue($card['value']),
                'suit' => $card['suit']
            ];
        });
        
        // Store the shuffled deck and reset the game state
        session(['cards' => $cards, 'current_index' => 0, 'score' => 0, 'lives' => 3]);
        
        // Return the first card
        return response()->json(['card' => $cards->first()]);
    }

    
}
