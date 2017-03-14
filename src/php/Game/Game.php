<?php

namespace FreeElephants\HexoNards\Game;

use FreeElephants\HexoNards\Board\Board;
use FreeElephants\HexoNards\Game\Action\PlayerActionInterface;
use FreeElephants\HexoNards\Game\Move\MoveGeneratorInterface;
use FreeElephants\HexoNards\Game\Move\MovesCounter;

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

    public function __construct(array $players, Board $board, MoveGeneratorInterface $moveGenerator)
    {
        $this->players = $players;
        $this->board = $board;
        $this->moveCounter = new MovesCounter($moveGenerator, new \ArrayIterator($players));
    }

    public function getActivePlayer(): Player
    {
        return $this->moveCounter->getCurrent();
    }

    public function invoke(PlayerActionInterface $command)
    {
        $command->execute($this->getActivePlayer());
        $this->moveCounter->tick();
    }
}