<?php

namespace Hexammon\HexoNards\Game\Action;

use Hexammon\HexoNards\Board\AbstractTile;
use Hexammon\HexoNards\Game\Action\Exception\TouchForeignOwnException;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\PlayerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ReplenishGarrison implements PlayerActionInterface
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

    public function execute(PlayerInterface $player)
    {
        if ($player !== $this->army->getOwner()) {
            throw new TouchForeignOwnException();
        }
        $this->army->replenish($this->numberOfUnits);
    }

    public function getTargetTile(): AbstractTile
    {
        return $this->army->getTile();
    }
}
