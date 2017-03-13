<?php

namespace FreeElephants\HexoNards\Game\Action;

use FreeElephants\HexoNards\Game\Action\Exception\TouchForeignOwnException;
use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Player;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ReplenishArmy implements PlayerActionInterface
{

    /**
     * @var int
     */
    private $numberOfUnits;
    /**
     * @var Army
     */
    private $army;

    public function __construct(Army $army, int $numberOfUnits = 1)
    {
        $this->army = $army;
        $this->numberOfUnits = $numberOfUnits;
    }

    public function execute(Player $player)
    {
        if ($player !== $this->army->getOwner()) {
            throw new TouchForeignOwnException();
        }
        $this->army->replenish($this->numberOfUnits);
    }
}