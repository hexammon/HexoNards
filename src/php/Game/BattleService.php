<?php

namespace FreeElephants\HexoNards\Game;

use FreeElephants\HexoNards\Board\Tile;
use FreeElephants\HexoNards\Exception\DomainException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BattleService
{

    public function attack(Tile $assaulterTile, Tile $defenderTile)
    {
        $assaulterArmy = $assaulterTile->getArmy();
        $defenderArmy = $defenderTile->getArmy();
        $this->assertArmyOwnersNotSame($assaulterArmy, $defenderArmy);
        $assaulterSize = count($assaulterArmy);
        $defenderSize = count($defenderArmy);
        $losses = ceil(min($assaulterSize, $defenderSize) / 2);
        $assaulterArmy->deduct($losses);
        $defenderArmy->deduct($losses);
    }

    private function assertArmyOwnersNotSame(Army $assaulterArmy, Army $defenderArmy)
    {
        if ($assaulterArmy->getOwner() === $defenderArmy->getOwner()) {
            throw new DomainException('Self attack detected. ');
        }
    }
}