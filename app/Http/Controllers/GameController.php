<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * Class GameController
 *
 * Controller to handle the game logic for the "Higher or Lower" card game.
 */
class GameController extends Controller
{
    /**
     * Display the game dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Shuffle the deck and return the first card.
     *
     * Fetches a fresh deck of cards, shuffles them, stores the deck in the session,
     * and returns the first card of the shuffled deck to start the game.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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

   /**
     * Handle the user's guess and return the result.
     *
     * Compares the user's guess with the next card in the deck. Updates and returns the 
     * user's score and lives based on whether the guess was correct.
     *
     * @param Request $request The request object
     * @return \Illuminate\Http\JsonResponse
     */
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
    
    /**
     * Transform the card value to a single uppercase letter if it's a face card.
     *
     * @param string $value The card value to transform
     * @return string The transformed value
     */
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

    /**
     * Get the numerical value of a card based on its game value.
     *
     * This function maps face card values to numbers, with 'A' as 1 and 'K' as 13.
     *
     * @param string $value The card value to convert
     * @return int|null The numerical value of the card
     */
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
