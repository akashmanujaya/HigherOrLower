@extends('layouts.app')

@section('content')
<div class="container" id="game_container">
    <div class="row justify-content-center align-items-center text-center">
        <div class="col-md-12 d-flex flex-column items-center">
            <div class="game-status mb-2 text-white">
                <span class="score fw-bolder" id="score">Score = 0</span>
                <span class="lives fw-bolder" id="lives">Lives = 3</span>
                <div>
                    <span class="high-score fw-bold">High Score = 3</span>
                </div>
                
            </div>

            <div class="card">
                <div class="card_top_left">
                    <p class="card_value"></p>
                    <img src="" alt="" class="card-suit">
                </div>
                <div class="card_suit d-flex justify-center">
                    <img src="" alt="" class="card-suit">
                </div>
                <div class="card_bottom_right mb-0">
                    <p class="card_value"></p>
                    <img src="" alt="" class="card-suit">
                </div>

            </div>
            <p class="guess-prompt mb-3 text-white">Will the next card be higher or lower than the one above?</p>
            <div class="guess-buttons mb-3">
                <button type="button" class="btn btn-success" id="higher_button">Higher</button>
                <button type="button" class="btn btn-danger" id="lower_button">Lower</button>
            </div>
            <button type="button" class="btn btn-primary" id="shuffle_deck">Shuffle Deck</button>
        </div>
    </div>
</div>
@endsection
