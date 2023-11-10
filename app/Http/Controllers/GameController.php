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

    // Method to handle the user's guess
    public function nextCard(Request $request)
    {
        $cards = session('cards');
        $current_index = session('current_index');
        $score = session('score');
        $lives = session('lives');

        // Determine the next card and increment the index
        $nextCard = $cards[++$current_index];
        $currentCard = $cards[$current_index - 1];

        
        
        session(['current_index' => $current_index]);

        // Determine if the user's guess is correct
        $currentCardValue = $this->getCardValue($currentCard['value']);
        $nextCardValue = $this->getCardValue($nextCard['value']);
        $guess = $request->input('guess');
        $correct = ($guess === 'higher' && $nextCardValue > $currentCardValue) || ($guess === 'lower' && $nextCardValue < $currentCardValue);

        if ($correct) {
            $score++;
        } else {
            $lives--;
        }

        // Update the session with the new score and lives
        session(['score' => $score, 'lives' => $lives]);

        // Transform the next card value
        $nextCard['value'] = $this->transformCardValue($nextCard['value']);

        return response()->json([
            'correct' => $correct,
            'nextCard' => $nextCard,
            'score' => $score,
            'lives' => $lives,
        ]);
    }

    private function transformCardValue($value)
    {
        $specialValues = [
            'ace' => 'A',
            'king' => 'K',
            'queen' => 'Q',
            'jack' => 'J'
        ];

        return $specialValues[strtolower($value)] ?? $value;
    }

    private function getCardValue($value)
    {
        $values = [
            "a" => 1, "2" => 2, "3" => 3, "4" => 4, "5" => 5, "6" => 6,
            "7" => 7, "8" => 8, "9" => 9, "10" => 10, "j" => 11,
            "q" => 12, "k" => 13
        ];

        return $values[strtolower($value)] ?? null;
    }
}
