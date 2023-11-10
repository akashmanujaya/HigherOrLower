import './bootstrap';
import './jquery-3.7.1.min';


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// Custom JS

$(document).ready(function() {
    let currentCard = null;
    let lives = 3;
    let score = 0;
    const maxScore = 3;

    // Start the game by shuffling the deck
    shuffleDeck();

    $('#higher_button, #lower_button').click(function() {
        if (!currentCard || lives === 0 || score >= maxScore) {
            alert('Game Over. Starting a new game');
            shuffleDeck();
            return;
        }

        const guess = this.id === 'higher_button' ? 'higher' : 'lower';
        getNextCard(guess);
    });

    $('#shuffle_deck').click(function() {
        shuffleDeck();
    });

    function shuffleDeck() {
        $.get('/game/shuffle', function(data) {
            currentCard = data.card;
            lives = 3;
            score = 0;
            updateCardDisplay(currentCard);
            updateGameStatus();
        });
    }

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

    function updateCardDisplay(card) {
        $('.card_value').text(card.value);
        $('.card-suit').attr('src', `/assets/images/${card.suit}.png`);
        $('.card-suit').attr('alt', card.suit.charAt(0).toUpperCase() + card.suit.slice(1));
    }

    function updateGameStatus() {
        $('#score').text(`Score = ${score}`);
        $('#lives').text(`Lives = ${lives}`);
    }
});

