# Higher or Lower Game Project

This project is a web-based card game where a player guesses whether the next card in a shuffled deck will be higher or lower than the current one. The game continues until the player makes three incorrect guesses or achieves the maximum score of 3.

## Getting Started

To run this project locally, follow these instructions.

### Prerequisites

- PHP >= 7.3
- Composer
- Laravel >= 8.x
- MySQL or another compatible database system

### Setup

1. **Clone the Repository**

   ```sh
   git clone https://github.com/akashmanujaya/HigherOrLower.git
   cd HigherOrLower
   ```

2. **Install Dependencies**

   ```sh
   composer install
   ```

3. **Create a Database**

   Create a new database in your preferred database management system.

4. **Environment Configuration**

   Copy the `.env.example` file to a new file named `.env`, and update your database credentials:

   ```plaintext
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

   Then, generate the application key:

   ```sh
   php artisan key:generate
   ```

5. **Run Migrations**

   To create the necessary tables in your database, run:

   ```sh
   php artisan migrate
   ```

6. **Start the Application**

   Use the following command to start the Laravel application:

   ```sh
   php artisan serve
   ```

   This will start the development server, making the application accessible via `http://localhost:8000` or another port if specified.

7. **Register and Play**

   Open your web browser and visit `http://localhost:8000/register` (or the respective URL if you have a different setup). Create an account to start playing the game.

## Game Logic

The game logic is handled in the `GameController`. Here's a brief overview:

- **Shuffle**: At the beginning of the game, a shuffled deck of cards is fetched from an API and stored in the session.
- **Guess**: When a player makes a guess, the next card in the session-stored deck is compared to the current card.
- **Scoring**: If the guess is correct, the player's score is incremented. If incorrect, a life is decremented.
- **End Game**: The game ends if the player loses all three lives or reaches the maximum score of 3. The player can then shuffle the deck to start a new game.

## Behind the Scenes

- **Frontend**: The game interface is built using Blade templates with Bootstrap for styling.
- **Backend**: Laravel handles the API calls, shuffling logic, and session management.
- **AJAX**: User interactions for guessing and shuffling trigger AJAX calls for a smooth experience without page reloads.

## Conclusion

This simple yet engaging game is an excellent example of how you can integrate frontend technologies with Laravel to create an interactive web application. Enjoy the game!