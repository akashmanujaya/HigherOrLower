<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    public function index()
    {
        $response = Http::get('https://higherorlower-api.netlify.app/json');
        $cards = collect($response->json())->shuffle();

        // Update card values
        $cards = $cards->map(function ($card) {
            return [
                'value' => $this->transformCardValue($card['value']),
                'suit' => $card['suit']
            ];
        });

        session([
            'cards' => $cards,
            'current_index' => 0,
            'score' => 0
        ]);

        $currentCard = $cards->first();

        return view('dashboard', ['currentCard' => $currentCard]);
    }

    private function transformCardValue($value)
    {
        // Transform 'king', 'queen', 'jack', and 'ace' to their first letters
        $specialValues = [
            'ace' => 'A',
            'king' => 'K',
            'queen' => 'Q',
            'jack' => 'J'
        ];

        return $specialValues[strtolower($value)] ?? $value;
    }
}
