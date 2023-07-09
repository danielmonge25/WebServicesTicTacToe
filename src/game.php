<?php

class Game {
    private $board;
    private $turn;
    private $winner;
    private $tie;

    public function __construct() {
        $this->board = array(
            array('', '', ''),
            array('', '', ''),
            array('', '', '')
        );
        $this->turn = 'X';
        $this->winner = false;
        $this->tie = false;
    }

    public function getBoard() {
        return $this->board;
    }

    public function getTurn() {
        return $this->turn;
    }

    public function restartGame($params) {
        $this->board = array(
            array('', '', ''),
            array('', '', ''),
            array('', '', '')
        );
        $this->turn = 'X';
        $this->winner = false;
        $this->tie = false;
        return ['board' => $this->board, 'turn' => $this->turn, 'winner' => $this->winner, 'tie' => $this->winner];
    }

    public function makeMove($row, $column) {
        
        if ($this->winner || $this->tie) {
            return ['info' => 'The game has already ended. Restart the game.'];
        }

        if ($this->board[$row][$column] !== '') {
            return ['info' => 'The position is already occupied.'];
        }

        if ($row < 0 || $row > 2 || $column < 0 || $column > 2) {
            return ['error' => 'Invalid move.'];
        }

        $this->board[$row][$column] = 'X';

        if ($this->checkWinner('X')) {
            $this->winner = 'X';
        } elseif ($this->allCellsOccupied($this->board)) {
            $this->tie = true;
        } else {
            $this->makeComputerMove();
            if ($this->checkWinner('O')) {
                $this->winner = 'O';
            }
        }

        return ['board' => $this->board, 'turn' => $this->turn, 'winner' => $this->winner, 'tie' => $this->tie];
    }

    private function allCellsOccupied($board) {
        foreach ($board as $row) {
            if (in_array('', $row)) {
                return false;
            }
        }
        return true;
    }

    private function makeComputerMove() {
        $emptyPositions = $this->getEmptyPositions();
        $randomPosition = array_rand($emptyPositions);
        $row = $emptyPositions[$randomPosition][0];
        $column = $emptyPositions[$randomPosition][1];

        $this->board[$row][$column] = 'O';
    }

    private function getEmptyPositions() {
        $emptyPositions = [];
        for ($row = 0; $row < 3; $row++) {
            for ($column = 0; $column < 3; $column++) {
                if ($this->board[$row][$column] === '') {
                    $emptyPositions[] = [$row, $column];
                }
            }
        }
        return $emptyPositions;
    }

    private function checkWinner($player) {
        for ($i = 0; $i < 3; $i++) {
            if ($this->board[$i][0] === $player && $this->board[$i][1] === $player && $this->board[$i][2] === $player) {
                return true;
            }
        }

        for ($j = 0; $j < 3; $j++) {
            if ($this->board[0][$j] === $player && $this->board[1][$j] === $player && $this->board[2][$j] === $player) {
                return true;
            }
        }

        if ($this->board[0][0] === $player && $this->board[1][1] === $player && $this->board[2][2] === $player) {
            return true;
        }
        if ($this->board[0][2] === $player && $this->board[1][1] === $player && $this->board[2][0] === $player) {
            return true;
        }

        return false;
    }
}

?>
