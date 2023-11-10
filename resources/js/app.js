import './bootstrap';
import './jquery-3.7.1.min';


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// Custom JS

$(function() {
    let currentCard = null;
    let lives = 3;
    let score = 0;
    const maxScore = 3;

    // Start the game by shuffling the deck
    shuffleDeck();

    /**
     * Event handler for the 'Higher' and 'Lower' buttons.
     * If the game is over due to score limit or no lives left, it resets the game.
     * Otherwise, it makes a guess based on the button clicked.
     */
    $('#higher_button, #lower_button').on( "click", function() {
        if (!currentCard || lives === 0 || score >= maxScore) {
            alert('Game Over. Starting a new game');
            shuffleDeck();
            return;
        }

        const guess = this.id === 'higher_button' ? 'higher' : 'lower';
        getNextCard(guess);
    });

    /**
     * Event handler for the 'Shuffle' button.
     * It shuffles the deck and resets the game state.
     */
    $('#shuffle_deck').on( "click", function() {
        shuffleDeck();
    });

    /**
     * Shuffles the deck and initializes the game.
     * Makes a GET request to the server to shuffle cards and updates the UI with the new card.
     */
    function shuffleDeck() {
        $.get('/game/shuffle', function(data) {
            currentCard = data.card;
            lives = 3;
            score = 0;
            updateCardDisplay(currentCard);
            updateGameStatus();
        });
    }

    /**
     * Sends the user's guess to the server and updates the game state.
     * Makes a POST request to the server with the user's guess and the current card,
     * then updates the score or lives based on the response.
     *
     * @param {string} guess - The user's guess ('higher' or 'lower').
     */
    function getNextCard(guess) {
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/game/next-card',
            type: 'POST',
            data: {
                _token: csrfToken,
                guess: guess,
                currentCard: currentCard
            },
            success: function(data) {
                if (data.correct) {
                    score++;
                } else {
                    lives--;
                }
                if (lives === 0 || score >= maxScore) {
                    alert('Game over! Starting a new game.');
                    shuffleDeck();
                    return;
                }
                currentCard = data.nextCard;
                updateCardDisplay(currentCard);
                updateGameStatus();
            }
        });
    }

    /**
     * Updates the card display in the UI.
     * Changes the displayed card value and suit image based on the card object provided.
     *
     * @param {object} card - The card object containing the value and suit to display.
     */
    function updateCardDisplay(card) {
        $('.card_value').text(card.value);
        $('.card-suit').attr('src', `/assets/images/${card.suit}.png`);
        $('.card-suit').attr('alt', card.suit.charAt(0).toUpperCase() + card.suit.slice(1));
    }

    /**
     * Updates the game status display in the UI.
     * Changes the displayed score and number of lives based on the current game state.
     */
    function updateGameStatus() {
        $('#score').text(`Score = ${score}`);
        $('#lives').text(`Lives = ${lives}`);
    }
});

