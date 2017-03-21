<?php

namespace FreeElephants\HexoNards\Game\Action;

use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Castle;
use FreeElephants\HexoNards\Game\PlayerInterface;

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