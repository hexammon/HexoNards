<?php

namespace Hexammon\HexoNards\Game\Action;

use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\Castle;
use Hexammon\HexoNards\Game\PlayerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class AssaultCastle implements PlayerActionInterface
{

    /**
     * @var Castle
     */
    private $castle;
    /**
     * @var Army
     */
    private $army;

    public function __construct(Castle $castle, Army $army)
    {
        $this->castle = $castle;
        $this->army = $army;
    }

    public function execute(PlayerInterface $player)
    {
        $defenderArmy = $this->castle->getArmy();
        Army::destroy($defenderArmy);
        $this->army->move($this->castle->getTile());
    }
}