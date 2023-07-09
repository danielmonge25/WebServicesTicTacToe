# Tic-Tac-Toe Game

This is a simple implementation of the Tic-Tac-Toe game with a client-server architecture. The game logic is written in PHP, and the client interface is created using HTML5 and JavaScript. Made in the course ' CI-0137 - Web Applications Development'

## Features

- Play Tic-Tac-Toe against the computer.
- Reset the game and start a new round.

## Technologies Used

- PHP for the server-side game logic.
- HTML5 and JavaScript for the client interface.
- JSON-RPC for communication between the client and server.

## Setup

1. Clone the repository or download the source code.
2. Ensure you have a web server environment set up (e.g., Apache, Nginx) with PHP support.
3. Place the source code files in the appropriate directory accessible by the web server.
4. Update the `serverUrl` variable in the client-side JavaScript code (`index.html`) to point to the server URL where the PHP files are hosted.
5. Make sure the server has write permissions to the directory where you intend to store the leaderboard data (e.g., a writable file or a database).

## Usage

1. Open the game in a web browser by accessing the `index.html` file.
2. Start playing Tic-Tac-Toe against the computer by clicking on the cells.
3. If you want to reset the game and start a new round, click the "Reset" button.
4. The top ten players' scores will be displayed below the game board, showing the duration of each game in seconds.
