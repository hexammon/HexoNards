<?php

namespace Hexammon\HexoNards\Game;

use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Game\Action\Exception\InapplicableActionException;
use Hexammon\HexoNards\Game\Action\PlayerActionInterface;
use Hexammon\HexoNards\Game\Move\MovesCounter;
use Hexammon\HexoNards\Game\Rules\ClassicRuleSet;
use Hexammon\HexoNards\Game\Rules\RuleSetInterface;

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
    /**
     * @var MovesCounter
     */
    private $moveCounter;
    /**
     * @var RuleSetInterface
     */
    private $ruleSet;

    public function __construct(array $players, Board $board, RuleSetInterface $ruleSet = null)
    {
        $this->players = $players;
        $this->board = $board;
        $this->ruleSet = $ruleSet ?: new ClassicRuleSet();
        $this->moveCounter = new MovesCounter($this->ruleSet->getMoveGenerator(), new \ArrayIterator($players));
    }

    public function getRuleSet(): RuleSetInterface
    {
        return $this->ruleSet;
    }

    public function getActivePlayer(): PlayerInterface
    {
        return $this->moveCounter->getCurrent();
    }

    public function invoke(PlayerActionInterface $command)
    {
        if ($this->ruleSet->isGameOver($this)) {
            throw new InapplicableActionException('Game over!');
        }
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