# Higher or Lower Game Project

This project is a web-based card game where a player guesses whether the next card in a shuffled deck will be higher or lower than the current one. The game continues until the player makes three incorrect guesses or achieves the maximum score of 3.

## Getting Started

To run this project locally, follow these instructions.

### Prerequisites

- PHP >= 8.0
- Composer
- Laravel >= 9.x
- MySQL or another compatible database system
- Node.js and npm

### Setup

1. **Clone the Repository**

   ```sh
   git clone https://github.com/akashmanujaya/HigherOrLower
   cd HigherOrLower
   ```

2. **Install PHP Dependencies**

   ```sh
   composer install
   ```

3. **Install JavaScript Dependencies**

   ```sh
   npm install
   ```

4. **Compile Assets**

   Compile your CSS and JavaScript assets using Laravel Vite:

   ```sh
   npm run dev
   ```

5. **Create a Database**

   Create a new database in your preferred database management system.

6. **Environment Configuration**

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

7. **Run Migrations**

   To create the necessary tables in your database, run:

   ```sh
   php artisan migrate
   ```

8. **Start the Application**

   Use the following command to start the Laravel application:

   ```sh
   php artisan serve
   ```

   This will start the development server, making the application accessible via `http://127.0.0.1:8000` or another port if specified.

9. **Register and Play**

   Open your web browser and visit `http://127.0.0.1:8000/register`. Create an account to start playing the game.

## Game Logic

The game logic is handled in the `GameController`. Here's a brief overview:

- **Shuffle**: At the beginning of the game, a shuffled deck of cards is fetched from an API and stored in the session.
- **Guess**: When a player makes a guess, the next card in the session-stored deck is compared to the current card.
- **Scoring**: If the guess is correct, the player's score is incremented. If incorrect, a life is decremented.
- **End Game**: The game ends if the player loses all three lives or reaches the maximum score of 3. The player can then shuffle the deck to start a new game.

## Behind the Scenes

- **Frontend**: The game interface is built using Blade templates with Bootstrap for styling. The assets are compiled using Laravel Mix, which requires Node.js and npm.
- **Backend**: Laravel handles the API calls, shuffling logic, and session management.
- **AJAX**: User interactions for guessing and shuffling trigger AJAX calls for a smooth experience without page reloads.

## Conclusion

This simple yet engaging game is an excellent example of how you can integrate frontend technologies with Laravel to create an interactive web application. Enjoy the game!