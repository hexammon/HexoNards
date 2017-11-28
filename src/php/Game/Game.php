<?php

namespace Hexammon\HexoNards\Game;

use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Game\Action\PlayerActionInterface;
use Hexammon\HexoNards\Game\Move\MoveGeneratorInterface;
use Hexammon\HexoNards\Game\Move\MovesCounter;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Game
{
    /**
     * @var array|PlayerInterface[]
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

    public function getActivePlayer(): PlayerInterface
    {
        return $this->moveCounter->getCurrent();
    }

    public function invoke(PlayerActionInterface $command)
    {
        $command->execute($this->getActivePlayer());
        $this->moveCounter->tick();
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getBoard(): Board
    {
        return $this->board;
    }
}