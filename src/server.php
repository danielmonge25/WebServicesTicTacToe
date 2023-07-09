<?php

require_once 'game.php';

session_start();

if (isset($_SESSION['game'])) {
    $game = $_SESSION['game'];
} else {
    $game = new Game();
    $_SESSION['game'] = $game;
}

$json = file_get_contents('php://input');
$request = json_decode($json, true);

if ($request && isset($request['method'])) {
    $response = handleRequest($request['method'], $request['params']);

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Invalid request']);
}

function handleRequest($method, $params)
{
    global $game;

    switch ($method) {
        case 'getBoard':
            return $game->getBoard();
        case 'getTurn':
            return $game->getTurn();
        case 'makeMove':
            if (isset($params[0]) && isset($params[1])) {
                return $game->makeMove($params[0], $params[1]);
            } else {
                return ['error' => 'Invalid parameters'];
            }
        case 'restartGame':
            return $game->restartGame($params);
        default:
            return ['error' => 'Method not found'];
    }
}
