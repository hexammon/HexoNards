<?php

namespace FreeElephants\HexoNards\Game;

use FreeElephants\HexoNards\Board\Board;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Game
{
    /**
     * @var array|Player[]
     */
    private $players;
    /**
     * @var Board
     */
    private $board;
    /**
     * @var Player
     */
    private $activePlayer;

    public function __construct(array $players, Board $board)
    {
        $this->players = $players;
        $this->activePlayer = $this->players[0];
        $this->board = $board;
    }

    public function getActivePlayer(): Player
    {
        return $this->activePlayer;
    }
}